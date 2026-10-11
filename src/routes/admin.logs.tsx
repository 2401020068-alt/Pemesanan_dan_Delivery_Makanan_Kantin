import { createFileRoute } from "@tanstack/react-router";
import { useStore } from "@/lib/store";
import { PageHeader, StatusBadge, Table } from "@/components/ui/kit";
import { fmtDateTime } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/logs")({
  head: () => seo("Log Aktivitas", "Riwayat tindakan admin sistem."),
  component: Logs,
});

function Logs() {
  const { state } = useStore();
  return (
    <div className="space-y-6">
      <PageHeader title="Log Aktivitas" subtitle="Semua tindakan admin tercatat di sini." />
      <Table head={["Waktu", "Admin", "Aksi", "Target", "Status"]} empty={!state.logs.length}>
        {state.logs.map((l) => (
          <tr key={l.id}><td>{fmtDateTime(l.time)}</td><td>{l.admin}</td><td className="font-medium">{l.action}</td><td>{l.target}</td><td><StatusBadge status={l.status} /></td></tr>
        ))}
      </Table>
    </div>
  );
}
