@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">

        @include('Template::partials.alert_box')
        <div class="col-md-12 campaign_wrapper">
            <div class="card custom--card bulk-launch-card">
                <div class="card-header bulk-launch-card__header">
                    <span class="bulk-launch-card__icon"><i class="las la-layer-group"></i></span>
                    <div>
                        <h5 class="card-title">@lang('Launch Bulk SMS Campaign')</h5>
                        <p>@lang('Distribute your workload across a connected Android SIM device.')</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="create-campaign">
                        <div class="create-campaign-form">
                            <form method="post" enctype="multipart/form-data"
                                action="{{ route('user.campaign.store') }}" class="disableSubmission">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Campaign Name')</label>
                                            <input type="text" class="form-control form--control" name="title" value="{{ old('title') }}"
                                                placeholder="@lang('Flash Sale VIP Offer Nov 2026')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Android Device')</label>
                                            <select name="device" class="form-control form--control select2--dropdown"
                                                required>
                                                <option value="" selected disabled>@lang('Please Select One')</option>
                                                @foreach ($allDevice as $device)
                                                    <option value="{{ @$device->id }}" @selected(old('device'))
                                                        data-sim='@json($device->sim)'>
                                                        {{ __(@$device->device_name) }}-{{ __(@$device->device_model) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Random Delay Between SMS')</label>
                                            <select name="random_delay_range" class="form-control form--control select2--dropdown" data-minimum-results-for-search="-1" required>
                                                <option value="0" @selected(old('random_delay_range') === '0')>@lang('No additional delay')</option>
                                                <option value="3-6" @selected(old('random_delay_range', '3-6') === '3-6')>@lang('3 to 6 Seconds (Recommended)')</option>
                                                <option value="6-12" @selected(old('random_delay_range') === '6-12')>@lang('6 to 12 Seconds')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Multi-SIM Load Balance')</label>
                                            <select name="load_balance_mode" class="form-control form--control select2--dropdown" data-minimum-results-for-search="-1" required>
                                                <option value="selected_sim" @selected(old('load_balance_mode', 'selected_sim') == 'selected_sim')>@lang('Use selected Android SIM')</option>
                                                <option value="evenly_split" @selected(old('load_balance_mode') == 'evenly_split')>@lang('Evenly Split across all Android Devices')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="required">@lang('Android SIM')</label>
                                            <select name="sim" class="form-control form--control select2--dropdown"
                                                data-minimum-results-for-search="-1" required
                                                data-selected="{{ old('sim') }}">
                                                <option value="" selected disabled>@lang('Please Select Sim')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Campaign Timing')</label>
                                            <select name="schedule" class="form-control form--control select2--dropdown"
                                                data-minimum-results-for-search="-1" required>
                                                <option value="1">@lang('Send Now')</option>
                                                <option value="2">@lang('Add Schedule')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none" id="date">
                                        <div class="form-group">
                                            <label for="date">@lang('Date')</label>
                                            <div class="input-group">
                                                <input type="text" name="date" class="form-control form--control date"
                                                    autocomplete="off">
                                                <span class="input-group-text">
                                                    <i class="las la-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="border-line-area mt-4 mb-2">
                                            <h6 class="border-line-title">@lang('Numbers you want to send message')</h6>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 number-selection-wrapper">
                                        <div class="form-group">
                                            <label class="form-label required">@lang('Target Contact Group')</label>
                                            <select name="selection_type" class="selectionType form-control form--control select2--dropdown" data-minimum-results-for-search="-1" required>
                                                <option value="" selected disabled>@lang('Select One')</option>
                                                <option value="{{ Status::CONTACT }}">@lang('Contacts')</option>
                                                <option value="{{ Status::GROUP }}">@lang('Groups')</option>
                                                <option value="{{ Status::DIRECT_INPUT }}">@lang('Direct Input')</option>
                                                <option value="{{ Status::DIRECT_INPUT_FROM_FILE }}">@lang('Direct Input From File')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 common contact-wrapper">
                                        <div class="form-group unchanged">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <label class="required">@lang('Mobile Numbers From Contact List')</label>
                                                <div class="form-check">
                                                    <input class="form-check-input select-all-contact" name="select_all_contact" type="checkbox" value="1" id="allContacts">
                                                    <label class="form-check-label" for="allContacts">
                                                      @lang('Select All Contacts')
                                                    </label>
                                                  </div>
                                            </div>
                                            <select class="form-control select2--dropdown contact-list" name="contact_list[]"
                                                multiple></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 common group-wrapper d-none">
                                        <div class="form-group unchanged">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <label class="required">@lang('Mobile Numbers From Group')</label>
                                                <div class="form-check">
                                                    <input class="form-check-input select-all-group" name="select_all_group" type="checkbox" value="1" id="allGroups">
                                                    <label class="form-check-label" for="allGroups">
                                                      @lang('Select All Groups')
                                                    </label>
                                                  </div>
                                            </div>
                                            <select class="form-control select2--dropdown group-list" name="group[]"
                                                multiple>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}">{{ __($group->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 common country-wrapper d-none">
                                        <div class="form-group">
                                            <label class="form-label required">@lang('Country')</label>
                                            <select name="country" class="form-control form--control select2--dropdown">
                                                @foreach ($countries as $key => $country)
                                                    @continue(in_array($key, ['US', 'RU', 'CN', 'IL', 'BY', 'IR', 'KP', 'CU', 'SY', 'AF', 'MM', 'VE', 'YE', 'SD', 'SO', 'LY', 'HT'], true))
                                                    <option data-mobile_code="{{ $country->dial_code }}"
                                                        value="{{ $country->country }}" data-code="{{ $key }}">
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 common mobile-wrapper d-none">
                                        <div class="form-group">
                                            <label class="form-label required">@lang('Mobile Numbers')</label>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <textarea name="mobile_numbers" class="form-control form--control" placeholder="@lang('Enter each number on a new line. Press Enter or Space after typing a number.')">{{ old('mobile_numbers') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 common file-wrapper d-none">
                                        <div class="form-group">
                                            <label>@lang('Upload File') </label> <strong class="uploadInFo"><i
                                                    class="fas fa-info-circle text--primary"></i></strong>
                                            <input type="file" class="form-control form--control uploadFile"
                                                id="uploadFile" accept=".txt,.csv,.xlsx" name="file">
                                            <small class="file-size float-end text--primary"></small>
                                            <x-file-upload-link />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="border-line-area mt-4 mb-2">
                                            <h6 class="border-line-title">@lang('Write Message')</h6>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('Message Template')</label>
                                        <select name="template_id" class="form-control form--control select2--dropdown"
                                            data-minimum-results-for-search="-1">
                                            <option value="" selected disabled>@lang('Select Template')</option>
                                            @foreach ($templates as $template)
                                                <option value="{{ @$template->id }}" @selected(old('template_id'))
                                                    data-message="{{ @$template->message }}">
                                                    {{ __(@$template->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="message-composer-label">
                                            <label>@lang('Message')</label>
                                            <div class="message-assist-controls" aria-label="@lang('Writing assistance')">
                                                <select class="message-language" aria-label="@lang('Message language')">
                                                    <option value="en">@lang('English')</option>
                                                    <option value="fr">@lang('Français')</option>
                                                </select>
                                                <label class="message-assist-toggle">
                                                    <input type="checkbox" class="message-autocorrect" checked>
                                                    <span>@lang('Auto-correct')</span>
                                                </label>
                                                <label class="message-assist-toggle">
                                                    <input type="checkbox" class="message-punctuation" checked>
                                                    <span>@lang('Auto punctuation')</span>
                                                </label>
                                            </div>
                                        </div>
                                        <textarea name="message" lang="en" spellcheck="true" class="form--control campaign-message" placeholder="@lang('Hi {Name}, enjoy 20% off your next purchase using code SPAMR20. Reply STOP to opt-out.')" required>{{ old('message') }}</textarea>
                                        <small class="message-assist-help">@lang('Corrections run when you leave the message field. Merge tags such as {Name} are preserved.')</small>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Shortcode')</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach (showShortCodes() as $value)
                                                <span class="btn btn--sm btn--danger shortcode-btn"
                                                    data-value="{{ $value }}">{{ $value }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base bulk-launch-submit"><i class="las la-play"></i> @lang('Start Campaign Queue')</button>
                                </div>
                            </form>
                        </div>
                        <div class="phone-preview-wrapper">
                            <div class="phone-preview bg-img"
                                data-background-image="{{ asset(activeTemplate(true) . 'images/dashboard/phone-modern.png') }}">
                                <div class="border">
                                    <div class="phone-screen">
                                        <div class="chat">
                                            <div class="messages" aria-live="polite"></div>
                                            <div class="bottom-area">
                                                <input type="text" disabled placeholder="@lang('Your message')"></input>
                                                <button class="btn" disabled>@lang('Send')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal custom--modal fade" id="info-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('File Upload Information')</h5>
                        <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="la la-close" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="alert alert--warning p-3 text-center" role="alert">
                                <p>
                                    @lang('The file you wish to upload has to be formatted as we provided template files. Any changes to these files will be considered as an invalid file format. Download links are provided below.')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/datepicker.en.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/datepicker.min.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', true).trigger("change");
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));

            $("select[name=device]").on('change', function(e) {
                generateSimOptions($(this));
            });

            if ($("select[name=device]").val()) {
                generateSimOptions($("select[name=device]"));
            }

            function generateSimOptions(device) {
                let sim = $(device).find('option:selected').data('sim');
                let html = "<option value='' selected disabled>@lang('Please select one')</option>";
                let selected = $("select[name=sim]").data('selected');
                if (sim) {
                    sim.forEach((element, index) => {
                    html +=
                        `<option value="${index}">${element.slot}-${element.name}</option>`
                    });
                }
                $("select[name=sim]").html(html);
            }

            function getContactList() {
                $('.contact-list').select2({
                    ajax: {
                        url: "{{ route('user.contact.search') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 1000,
                        data: function(params) {
                            return {
                                search: params.term,
                                page: params.page,
                            };
                        },
                        processResults: function(response, params) {
                            params.page = params.page || 1;
                            let data = response.contacts.data;
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.mobile,
                                        id: item.id
                                    }
                                }),
                                pagination: {
                                    more: response.more
                                }
                            };
                        },
                        cache: false
                    },

                });
            }

            getContactList();
            $('.contact-wrapper').addClass('d-none');

            $("select[name=schedule]").on('change', function(e) {
                let schedule = $(this).val();
                if (schedule == 1) {
                    $("#date").addClass('d-none');
                } else {
                    $("#date").removeClass('d-none');
                }
            });

            $(".uploadInFo").on('click', function(e) {
                $("#info-modal").modal('show');
            });

            $(".uploadFile").on('change', function(e) {
                let file = e.target.files[0];
                let fileExtention = file.name.split('.').pop();
                if (fileExtention != 'csv' && fileExtention != 'xlsx' && fileExtention != 'txt') {
                    notify('error', "@lang('Title')");
                    document.querySelector('.uploadFile').value = '';
                    return false;
                }
                let size = fileSize(file.size);
                $(".file-size").text(size);
            });

            ///get the file size on js file upload
            function fileSize(bytes) {

                let marker = 1024; // Change to 1000 if required
                let kiloBytes = marker; // One Kilobyte is 1024 bytes
                let megaBytes = marker * marker; // One MB is 1024 KB
                let gigaBytes = marker * marker * marker; // One GB is 1024 MB
                let teraBytes = marker * marker * marker * marker; // One TB is 1024 GB

                if (bytes < kiloBytes) return bytes + " Bytes";
                else if (bytes < megaBytes) return (bytes / kiloBytes).toFixed(2) + " KB";
                else if (bytes < gigaBytes) return (bytes / megaBytes).toFixed(2) + " MB";
                else return (bytes / gigaBytes).toFixed(2) + " GB";
            }

            $('.select-all-contact').on('click', function(e) {
                if (this.checked) {
                    let message = "@lang('All Contacts')";
                    $('.contact-list').html(
                        `<option value="select_all_contact" selected disabled>${message}</option>`);
                    $('.contact-list').attr('disabled', true);
                } else {
                    $('.contact-list').find(`option[value=select_all_contact]`).remove();
                    $('.contact-list').attr('disabled', false);
                }
            });
            $('.select-all-group').on('click', function(e) {
                if (this.checked) {
                    let message = "@lang('All Groups')";
                    $('.group-list').html(
                        `<option value="select_all_group" selected disabled>${message}</option>`);
                    $('.group-list').attr('disabled', true);
                } else {
                    $('.group-list').find(`option[value=select_all_group]`).remove();
                    $('.group-list').attr('disabled', false);
                    let html = "";
                    @foreach ($groups as $group)
                        html += `<option value="{{ $group->id }}">{{ __($group->name) }}</option>`;
                    @endforeach
                    $('.group-list').html(html);
                    $('.group-list').select2({
                        dropdownParent: $('.group-wrapper').find('form-group')
                    });
                }
            });

            $("select[name=template_id]").on('change', function(e) {
                let message = $("select[name=template_id]").find('option:selected').data('message');
                $("textarea[name=message]").val(message);
                messagePreview();
            });

            $("textarea[name=message]").on('input change', function() {
                messagePreview();
            });

            $("textarea[name=message]").on('blur', function() {
                applyMessageAssistance();
            });

            $('.message-language').on('change', function () {
                $("textarea[name=message]").attr('lang', this.value);
                applyMessageAssistance();
            });

            $('.message-autocorrect, .message-punctuation').on('change', function () {
                applyMessageAssistance();
            });

            messagePreview();

            $('.shortcode-btn').on('click', function (e) {
                let value = $(this).data('value');
                let textarea = $("textarea[name=message]");
                let cursorPos = textarea.prop("selectionStart");

                let text = textarea.val();

                let newText = text.substring(0, cursorPos) + value + text.substring(cursorPos);
                textarea.val(newText);

                textarea.focus();
                textarea.prop("selectionStart", cursorPos + value.length);
                textarea.prop("selectionEnd", cursorPos + value.length);

                messagePreview();
            });

            $('.date').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                timepicker: true,
                minDate: new Date(),
                timeFormat: 'hh:ii'
            });

            $('.date, .time-picker').on('keypress keyup change paste', function(e) {
                return false;
            });

            function messagePreview() {
                const message = $("textarea[name=message]").val() || '';
                const $preview = $('.phone-screen .chat .messages');

                $preview.empty();
                if (!message.trim()) {
                    $preview.append($('<p>', {
                        class: 'phone-preview-placeholder',
                        text: "{{ trans('Your campaign message will appear here') }}"
                    }));
                    return;
                }

                // Build text nodes and anchors separately: message content is never interpreted as HTML.
                const $bubble = $('<div>', { class: 'myMessage' });
                const urlPattern = /(?:https?:\/\/|www\.)[^\s<>{}]+/gi;
                let cursor = 0;

                message.replace(urlPattern, function (url, offset) {
                    $bubble.append(document.createTextNode(message.slice(cursor, offset)));
                    const trailingPunctuation = (url.match(/[.,!?;:]+$/) || [''])[0];
                    const visibleUrl = trailingPunctuation ? url.slice(0, -trailingPunctuation.length) : url;
                    const href = visibleUrl.startsWith('www.') ? `https://${visibleUrl}` : visibleUrl;
                    $('<a>', {
                        class: 'message-preview-link',
                        href: href,
                        text: visibleUrl,
                        target: '_blank',
                        rel: 'noopener noreferrer',
                        title: "{{ trans('Open link') }}"
                    }).appendTo($bubble);
                    if (trailingPunctuation) $bubble.append(document.createTextNode(trailingPunctuation));
                    cursor = offset + url.length;
                    return url;
                });
                $bubble.append(document.createTextNode(message.slice(cursor)));
                $preview.append($bubble);
                $preview.scrollTop($preview.prop('scrollHeight'));
            }

            function applyMessageAssistance() {
                const $field = $("textarea[name=message]");
                let value = $field.val() || '';
                if (!value.trim()) return;

                const language = $('.message-language').val();
                if ($('.message-autocorrect').is(':checked')) {
                    const corrections = language === 'fr'
                        ? [
                            [/\bj ai\b/gi, "j'ai"], [/\bc est\b/gi, "c'est"],
                            [/\bn est\b/gi, "n'est"], [/\bca\b/g, 'ça']
                        ]
                        : [
                            [/\bteh\b/gi, 'the'], [/\brecieve\b/gi, 'receive'],
                            [/\bseperate\b/gi, 'separate'], [/\bdont\b/gi, "don't"], [/\bcant\b/gi, "can't"]
                        ];
                    corrections.forEach(([pattern, replacement]) => value = value.replace(pattern, replacement));
                }

                if ($('.message-punctuation').is(':checked')) {
                    value = value.replace(/[ \t]+/g, ' ').replace(/ *\n */g, '\n').trim();
                    value = value.replace(/(^|[.!?]\s+)([a-zàâçéèêëîïôûùüÿñæœ])/g, (match, start, letter) => start + letter.toUpperCase());
                    if (!/[.!?…]$/.test(value)) value += '.';
                }

                if ($field.val() !== value) $field.val(value);
                messagePreview();
            }

            $('.selectionType').on('change', function(){
                let type = $(this).val();

                $('.common').addClass('d-none');

                $('.contact-list').removeAttr('required');
                $('.group-list').removeAttr('required');
                $('[name=country]').removeAttr('required');
                $('[name=mobile_numbers]').removeAttr('required');
                $('[name=file]').removeAttr('required');

                $('.contact-list').val('').trigger('change');
                $('[name=select_all_contact]').prop('checked', false);
                $('.contact-list').attr('disabled', false);
                $('.group-list').val('').trigger('change');
                $('.group-list').attr('disabled', false);
                $('[name=select_all_group]').prop('checked', false);
                $('[name=mobile_numbers]').val('');
                $('[name=file]').val('');

                if(type == "{{ Status::CONTACT }}"){
                    $('.contact-wrapper').removeClass('d-none');
                    $('.contact-list').attr('required', true);

                }else if(type == "{{ Status::GROUP }}"){
                    $('.group-wrapper').removeClass('d-none');
                    $('.group-list').attr('required', true);

                }else if(type == "{{ Status::DIRECT_INPUT }}"){
                    $('.mobile-wrapper').removeClass('d-none');
                    $('.country-wrapper').removeClass('d-none');
                    $('[name=country]').attr('required', true);
                    $('[name=mobile_numbers]').attr('required', true);
                }else if(type == "{{ Status::DIRECT_INPUT_FROM_FILE }}"){
                    $('.file-wrapper').removeClass('d-none');
                    $('[name=file]').attr('required', true);
                }
            });

            $('[name=mobile_numbers]').on('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();

                    let textarea = $(this);
                    let value = textarea.val().trim() + '\n';

                    textarea.val(value);
                    textarea.prop({ selectionStart: value.length, selectionEnd: value.length });
                }
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .bulk-launch-card {
            width: 100%;
            max-width: none;
            margin: 0;
            overflow: hidden !important;
            border: 1px solid #dbe5f1;
            border-radius: 18px;
            box-shadow: 0 16px 42px rgba(30, 57, 91, .11);
        }

        .bulk-launch-card__header {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 22px 25px;
            border-bottom: 1px solid #e4ebf4;
            background: linear-gradient(115deg, #f5fbff, #fff);
        }

        .bulk-launch-card__header .card-title { margin: 0; color: #173654; font-size: 20px; font-weight: 700; }
        .bulk-launch-card__header p { margin: 3px 0 0; color: #7086a2; font-size: 13px; }
        .bulk-launch-card__icon { display: grid; width: 42px; height: 42px; place-items: center; color: #169fdf; border-radius: 12px; background: #e2f4fe; font-size: 24px; }
        .bulk-launch-card .card-body { padding: 28px; }
        .bulk-launch-card .form-group > label, .bulk-launch-card .form-label { color: #36506e; font-size: 13px; font-weight: 600; }
        .bulk-launch-card .form--control, .bulk-launch-card .form-control { border-color: #d6e1ed; border-radius: 11px; background: #fcfdff; }
        .bulk-launch-card .form--control:focus, .bulk-launch-card .form-control:focus { border-color: #169fdf; box-shadow: 0 0 0 3px rgba(22, 159, 223, .10); }
        .bulk-launch-card .campaign-message { min-height: 118px; resize: vertical; }
        .message-composer-label { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 8px; }
        .message-composer-label > label { margin-bottom: 0; }
        .message-assist-controls { display: flex; align-items: center; justify-content: flex-end; flex-wrap: wrap; gap: 8px 12px; }
        .message-language { height: 28px; min-width: 90px; padding: 2px 8px; color: #36506b; font-size: 12px; border: 1px solid #d6e1ed; border-radius: 7px; background: #fff; }
        .message-assist-toggle { display: inline-flex; align-items: center; gap: 5px; margin: 0; color: #526b84; font-size: 12px; font-weight: 500; white-space: nowrap; cursor: pointer; }
        .message-assist-toggle input { width: 14px; height: 14px; accent-color: #14a9e7; cursor: pointer; }
        .message-assist-help { display: block; margin-top: 6px; color: #7c90a6; font-size: 11px; }
        .bulk-launch-card .border-line-title { color: #173654; }
        .bulk-launch-submit { min-width: 205px; border-radius: 11px; background: #14a9e7 !important; box-shadow: 0 7px 15px rgba(20, 169, 231, .24); }
        .bulk-launch-submit:hover { background: #078dca !important; }

        .mobile-wrapper textarea{
            height: 215px;
        }

        .select2-container--default .select2-selection--multiple {
            border-color: #ddd;
            min-height: calc(1.8rem + 1rem + 2px) !important;
            height: auto;
        }

        .select2-container .select2-selection--single {
            border-color: #ddd;
            min-height: calc(1.8rem + 1rem + 2px) !important;
            height: auto;
        }

        .uploadInFo {
            cursor: pointer;
        }

        .datepickers-container {
            z-index: 9999999999;
        }

        .adz-modal {
            width: 300px;
            border-radius: 4px;
            pointer-events: auto;
            box-shadow: 0 11px 15px -7px rgb(0 0 0 / 20%), 0 24px 38px 3px rgb(0 0 0 / 14%), 0 9px 46px 8px rgb(0 0 0 / 12%);
            top: 50%;
            left: 50%;
            z-index: 99999999999999999999;
            position: absolute;
            display: none;
        }

        .adz-modal__card {
            padding: 5px 24px 15px;
            box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
            background-color: #1867c0;
            border-radius: 4px;
        }

        .adz-modal__text {
            display: block;
            margin-bottom: 5px;
            color: hsla(0, 0%, 100%, .7);
        }

        .adz-progressbar {
            width: 100%;
            height: 4px;
            background: transparent;
            overflow: hidden;
            position: relative;
            transition: .2s cubic-bezier(.4, 0, .6, 1);
        }

        .adz-progressbar__bg {
            width: 100%;
            position: absolute;
            bottom: 0;
            top: 0;
            left: 0;
            opacity: 0.3;
            border-color: #fff !important;
            background-color: #fff !important;
            transition: inherit;
        }

        .adz-progressbar__buffer {
            width: 100%;
            height: inherit;
            position: absolute;
            left: 0;
            top: 0;
            transition: inherit;
        }

        .adz-progressbar__indeterminate {
            width: auto;
            height: inherit;
            animation-play-state: running;
            animation-duration: 2.2s;
            animation-iteration-count: infinite;
            position: absolute;
            bottom: 0;
            left: 0;
            top: 0;
            right: auto;
            will-change: left, right;
            border-color: #fff !important;
            background-color: #fff !important;
        }

        .adz-progressbar__indeterminate.long {
            animation-name: indeterminate-ltr;
        }

        .adz-progressbar__indeterminate.short {
            animation-name: indeterminate-short-ltr;
        }

        @keyframes indeterminate-ltr {
            0% {
                left: -90%;
                right: 100%;
            }

            60% {
                left: -90%;
                right: 100%;
            }

            100% {
                left: 100%;
                right: -35%;
            }
        }

        @keyframes indeterminate-short-ltr {
            0% {
                left: -200%;
                right: 100%;
            }

            60% {
                left: 107%;
                right: -8%;
            }

            100% {
                left: 107%;
                right: -8%;
            }
        }

        .bottom-area {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 0;
            background: #fff;
            display: flex;
            border-top: 1px solid hsl(var(--dark) / .1);
        }

        .bottom-area input {
            border: 0;
            padding-inline: 12px;
            flex: 1;
        }

        .bottom-area .btn {
            flex-shrink: 0;
            padding-inline: 12px;
            border: 0;
        }

        .shortcode-btn {
            cursor: pointer;
            padding: 4px 5px !important;
            font-size: 12px !important;
        }

        .phone-preview {
            width: 300px;
            height: 652px;
            border-radius: 10px !important;
            background-size: 100% 100% !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            position: relative;
        }

        .phone-preview::after {
            position: absolute;
            z-index: 3;
            inset: 0;
            pointer-events: none;
            content: '';
            background-image: url("{{ asset(activeTemplate(true) . 'images/dashboard/phone-modern.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100% 100%;
        }

        .campaign_wrapper .border {
            position: absolute;
            top: 5.5%;
            bottom: 5.3%;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
            width: calc(100% - 12%);
            border: 0 !important;
            border-radius: 37px 37px 42px 42px;
            background: #fff;
            z-index: 1;
        }

        .phone-screen,
        .phone-screen .chat {
            position: relative;
            height: 100%;
            width: 100%;
        }

        .chat .messages {
            display: flex;
            align-content: flex-end;
            flex-wrap: wrap;
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
            box-sizing: border-box;
            height: calc(100% - 42px);
            width: 100%;
            padding: 14px 12px;
        }

        .phone-preview-placeholder {
            align-self: center;
            width: 100%;
            margin: 0;
            padding: 0 18px;
            color: #a9b7c7;
            font-size: 12px;
            line-height: 1.45;
            text-align: center;
        }

        .chat .message {
            display: block;
            width: 98%;
            padding: 0.5%;
        }

        .chat .myMessage,
        .chat .fromThem {
            max-width: 90%;
        }

        .chat .myMessage,
        form.chat .fromThem {
            font-size: 12px;
        }

        .chat .myMessage {
            background: hsl(var(--dark) / .05);
            color: #000b16;
            float: right;
            clear: both;
            border-bottom-right-radius: 20px 0px \9;
        }

        .chat .myMessage:before {
            content: "";
            position: absolute;
            z-index: 1;
            bottom: -2px;
            right: -12px;
            height: 20px;
            border-right: 25px solid #f2f4f4;
            border-bottom-left-radius: 16px 14px;
            transform: translate(0, -2px);
        }

        .chat .myMessage:after {
            content: "";
            position: absolute;
            z-index: 1;
            bottom: -2px;
            right: -42px;
            width: 12px;
            height: 20px;
            background: white;
            border-bottom-left-radius: 10px;
            -webkit-transform: translate(-30px, -2px);
            transform: translate(-30px, -2px);
        }

        .chat .myMessage,
        .fromThem {
            position: relative;
            padding: 10px 20px;
            color: hsl(var(--dark));
            border-radius: 25px;
            clear: both;
            font: 400 15px 'Open Sans', sans-serif;
            white-space: pre-wrap;
        }

        .phone-preview .message-preview-link {
            color: #087de1;
            font-weight: 600;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
            overflow-wrap: anywhere;
        }

        .phone-preview .message-preview-link:hover {
            color: #005db0;
        }

        .chat .myMessage,
        .chat .fromThem {
            max-width: 80%;
            word-wrap: break-word;
            margin-bottom: 20px;
            margin-right: 12px;
        }

        .create-campaign {
            display: flex;
            align-items: flex-start;
            gap: 32px;
        }

        .create-campaign-form {
            flex: 1;
        }

        .phone-preview-wrapper {
            position: sticky;
            top: 200px;
            flex-shrink: 0;
        }

        .custom--card:has(.phone-preview-wrapper) {
            overflow: unset;
        }

        @media (max-width: 767px) {
            .bulk-launch-card .card-body { padding: 20px 15px; }
            .bulk-launch-card__header { padding: 18px 16px; }
            .bulk-launch-card__header .card-title { font-size: 17px; }
            .phone-preview-wrapper {
                display: none;
            }
            .message-composer-label { align-items: flex-start; flex-direction: column; }
            .message-assist-controls { justify-content: flex-start; }
        }
    </style>
@endpush
