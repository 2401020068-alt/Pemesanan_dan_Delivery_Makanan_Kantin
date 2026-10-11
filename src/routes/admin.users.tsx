import { useState } from "react";
import { createFileRoute } from "@tanstack/react-router";
import { Search } from "lucide-react";
import { useStore } from "@/lib/store";
import { Button, Img, Input, PageHeader, Select, StatusBadge, Table } from "@/components/ui/kit";
import { ROLE_LABEL, fmtDate } from "@/lib/format";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/admin/users")({
  head: () => seo("Manajemen Pengguna", "Kelola akun pengguna kantin digital."),
  component: Users,
});

function Users() {
  const { state, setUserStatus } = useStore();
  const [q, setQ] = useState("");
  const [role, setRole] = useState("");
  const list = state.users.filter((u) => (!role || u.role === role) && (u.name + u.email).toLowerCase().includes(q.toLowerCase()));
  return (
    <div className="space-y-6">
      <PageHeader title="Pengguna" subtitle="Aktifkan atau nonaktifkan akun pengguna." />
      <div className="flex flex-col gap-3 sm:flex-row">
        <div className="relative flex-1"><Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" /><Input className="pl-9" placeholder="Cari nama atau email" value={q} onChange={(e) => setQ(e.target.value)} /></div>
        <Select value={role} onChange={(e) => setRole(e.target.value)} className="sm:w-48"><option value="">Semua role</option>{Object.entries(ROLE_LABEL).map(([k, v]) => <option key={k} value={k}>{v}</option>)}</Select>
      </div>
      <Table head={["Pengguna", "Role", "Bergabung", "Status", "Aksi"]} empty={!list.length}>
        {list.map((u) => (
          <tr key={u.id}>
            <td><div className="flex items-center gap-3"><Img src={u.avatar} alt={u.name} className="h-9 w-9 rounded-full" /><div><p className="font-medium">{u.name}</p><p className="text-xs text-muted-foreground">{u.email}</p></div></div></td>
            <td>{ROLE_LABEL[u.role]}</td>
            <td>{fmtDate(u.joined)}</td>
            <td><StatusBadge status={u.status} /></td>
            <td>{u.role !== "admin" && <Button size="sm" variant={u.status === "active" ? "outline" : "primary"} onClick={() => setUserStatus(u.id, u.status === "active" ? "inactive" : "active")}>{u.status === "active" ? "Nonaktifkan" : "Aktifkan"}</Button>}</td>
          </tr>
        ))}
      </Table>
    </div>
  );
}
