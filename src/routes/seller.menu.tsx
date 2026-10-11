import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Edit, Plus, Trash2, UtensilsCrossed } from "lucide-react";
import { useStore } from "@/lib/store";
import { CURRENT } from "@/data/mockData";
import { Badge, Button, EmptyState, Img, Input, Modal, PageHeader, Select, Table, Textarea } from "@/components/ui/kit";
import { rp } from "@/lib/format";
import { seo } from "@/lib/seo";
import type { MenuItem } from "@/types";

export const Route = createFileRoute("/seller/menu")({
  head: () => seo("Kelola Menu", "Tambah, ubah, dan hapus menu warung."),
  component: MenuPage,
});

function MenuPage() {
  const { state, saveMenu, deleteMenu } = useStore();
  const shop = state.shops.find((s) => s.ownerId === CURRENT.seller)!;
  const menus = state.menus.filter((m) => m.shopId === shop.id);
  const [editing, setEditing] = useState<MenuItem | null>(null);
  const [del, setDel] = useState<MenuItem | null>(null);
  const blank: MenuItem = { id: `m${Date.now()}`, shopId: shop.id, name: "", description: "", category: "Makanan", price: 10000, image: "", available: true };
  return (
    <div>
      <PageHeader title="Kelola Menu" subtitle={shop.name} action={<Button icon={Plus} onClick={() => setEditing({ ...blank, id: `m${Date.now()}` })}>Tambah Menu</Button>} />
      {!menus.length ? <EmptyState icon={UtensilsCrossed} title="Belum ada menu" action={<Button icon={Plus} onClick={() => setEditing(blank)}>Tambah Menu</Button>} /> : (
        <Table head={["Foto", "Nama menu", "Kategori", "Harga", "Ketersediaan", "Aksi"]}>
          {menus.map((m) => (
            <tr key={m.id}>
              <td><Img src={m.image} alt={m.name} className="h-12 w-12 rounded-lg" /></td>
              <td><p className="font-medium">{m.name}</p><p className="max-w-xs truncate text-xs text-muted-foreground">{m.description}</p></td>
              <td>{m.category}</td>
              <td className="font-medium">{rp(m.price)}</td>
              <td><button onClick={() => saveMenu({ ...m, available: !m.available })}><Badge tone={m.available ? "success" : "neutral"}>{m.available ? "Tersedia" : "Habis"}</Badge></button></td>
              <td><div className="flex gap-1"><Button size="sm" variant="outline" icon={Edit} onClick={() => setEditing(m)}>Edit</Button><Button size="sm" variant="ghost" icon={Trash2} className="text-destructive" onClick={() => setDel(m)} aria-label="Hapus" /></div></td>
            </tr>
          ))}
        </Table>
      )}
      <Modal open={!!editing} onClose={() => setEditing(null)} title={editing && menus.some((m) => m.id === editing.id) ? "Edit Menu" : "Tambah Menu"}>
        {editing && (
          <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); const f = new FormData(e.currentTarget); saveMenu({ ...editing, name: String(f.get("name")), description: String(f.get("desc")), category: String(f.get("cat")), price: Number(f.get("price")), image: String(f.get("image")), available: f.get("avail") === "on" }); setEditing(null); }}>
            {editing.image && <Img src={editing.image} alt="" className="h-32 w-full rounded-xl" />}
            <Input name="name" label="Nama menu" defaultValue={editing.name} required />
            <div className="grid grid-cols-2 gap-4">
              <Input name="price" label="Harga (Rp)" type="number" min={1000} step={500} defaultValue={editing.price} required />
              <Select name="cat" label="Kategori" defaultValue={editing.category}><option>Makanan</option><option>Minuman</option><option>Camilan</option></Select>
            </div>
            <Input name="image" label="URL foto" defaultValue={editing.image} placeholder="https://..." />
            <Textarea name="desc" label="Deskripsi" defaultValue={editing.description} />
            <label className="flex items-center gap-2 text-sm"><input type="checkbox" name="avail" defaultChecked={editing.available} className="h-4 w-4 accent-primary" /> Menu tersedia</label>
            <div className="flex justify-end gap-2"><Button type="button" variant="outline" onClick={() => setEditing(null)}>Batal</Button><Button type="submit">Simpan</Button></div>
          </form>
        )}
      </Modal>
      <Modal open={!!del} onClose={() => setDel(null)} title="Hapus menu?">
        <p className="text-sm text-muted-foreground">Menu "{del?.name}" akan dihapus permanen.</p>
        <div className="mt-5 flex justify-end gap-2"><Button variant="outline" onClick={() => setDel(null)}>Batal</Button><Button variant="danger" icon={Trash2} onClick={() => { deleteMenu(del!.id); setDel(null); }}>Hapus</Button></div>
      </Modal>
    </div>
  );
}
