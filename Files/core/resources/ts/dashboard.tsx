import { createRoot } from 'react-dom/client';
import './dashboard.css';

type DashboardKind = 'admin' | 'user';

type DashboardMount = HTMLElement & {
    dataset: DOMStringMap & {
        dashboardKind?: DashboardKind;
        dashboardName?: string;
        dashboardDetail?: string;
    };
};

function DashboardModule({ kind, name, detail }: { kind: DashboardKind; name: string; detail: string }) {
    const title = kind === 'admin' ? 'Admin workspace' : 'Your workspace';

    return (
        <section className="react-dashboard-module" aria-label={title}>
            <div>
                <span className="react-dashboard-module__eyebrow">Spamr dashboard</span>
                <h2>{name ? `Welcome back, ${name}` : title}</h2>
                <p>{detail}</p>
            </div>
            <span className="react-dashboard-module__badge">React + TypeScript ready</span>
        </section>
    );
}

document.querySelectorAll<DashboardMount>('[data-react-dashboard]').forEach((element) => {
    const kind = element.dataset.dashboardKind === 'admin' ? 'admin' : 'user';
    const name = element.dataset.dashboardName ?? '';
    const detail = element.dataset.dashboardDetail ?? 'Your existing Blade dashboard remains fully available.';

    createRoot(element).render(<DashboardModule kind={kind} name={name} detail={detail} />);
});
