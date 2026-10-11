import { useState } from "react";
import { useNavigate } from "@tanstack/react-router";
import { Edit, LogOut, Mail, Phone, Save, ShieldCheck, Calendar } from "lucide-react";
import { useLookup, useStore } from "@/lib/store";
import { Button, Card, Img, InfoRow, Input, PageHeader, StatusBadge } from "@/components/ui/kit";
import { fmtDate, ROLE_LABEL } from "@/lib/format";
import type { Role } from "@/types";

export function ProfileView({ role }: { role: Role }) {
  const me = useLookup().me(role);
  const { updateUser } = useStore();
  const [edit, setEdit] = useState(false);
  const navigate = useNavigate();
  return (
    <div className="max-w-3xl">
      <PageHeader title="Profil" subtitle="Kelola informasi akun Anda." />
      <Card className="overflow-hidden">
        <div className="h-24 bg-gradient-to-r from-primary to-secondary" />
        <div className="px-6 pb-6">
          <div className="-mt-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div className="flex items-end gap-4">
              <Img src={me.avatar} alt={me.name} className="h-20 w-20 rounded-2xl border-4 border-card" />
              <div className="pb-1"><p className="font-display text-lg font-semibold">{me.name}</p><p className="text-sm text-muted-foreground">{ROLE_LABEL[role]}</p></div>
            </div>
            {!edit && <Button variant="outline" icon={Edit} onClick={() => setEdit(true)}>Edit Profil</Button>}
          </div>
          {edit ? (
            <form className="mt-6 grid gap-4 sm:grid-cols-2" onSubmit={(e) => {
              e.preventDefault();
              const f = new FormData(e.currentTarget);
              updateUser(me.id, { name: String(f.get("name")), email: String(f.get("email")), phone: String(f.get("phone")), ...(role === "buyer" ? { address: String(f.get("address")) } : {}) });
              setEdit(false);
            }}>
              <Input name="name" label="Nama" defaultValue={me.name} required />
              <Input name="email" label="Email" type="email" defaultValue={me.email} required />
              <Input name="phone" label="Nomor HP" defaultValue={me.phone} required />
              {role === "buyer" && <Input name="address" label="Alamat default" defaultValue={me.address} />}
              <div className="flex gap-2 sm:col-span-2"><Button type="submit" icon={Save}>Simpan</Button><Button type="button" variant="outline" onClick={() => setEdit(false)}>Batal</Button></div>
            </form>
          ) : (
            <div className="mt-6 divide-y divide-border">
              <InfoRow label="Email"><span className="inline-flex items-center gap-2"><Mail className="h-4 w-4 text-muted-foreground" />{me.email}</span></InfoRow>
              <InfoRow label="Nomor HP"><span className="inline-flex items-center gap-2"><Phone className="h-4 w-4 text-muted-foreground" />{me.phone}</span></InfoRow>
              <InfoRow label="Bergabung"><span className="inline-flex items-center gap-2"><Calendar className="h-4 w-4 text-muted-foreground" />{fmtDate(me.joined)}</span></InfoRow>
              <InfoRow label="Status akun"><span className="inline-flex items-center gap-2"><ShieldCheck className="h-4 w-4 text-muted-foreground" /><StatusBadge status={me.status} /></span></InfoRow>
              {me.address && <InfoRow label="Alamat default">{me.address}</InfoRow>}
            </div>
          )}
        </div>
      </Card>
      <Button variant="outline" icon={LogOut} className="mt-6 text-destructive" onClick={() => navigate({ to: "/login" })}>Logout</Button>
    </div>
  );
}
