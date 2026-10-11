import { createContext, useCallback, useContext, useEffect, useMemo, useState, type ReactNode } from "react";
import * as mock from "@/data/mockData";
import type { ActivityLog, Approval, CartItem, Dispute, DisputeStatus, DeliveryStatus, MenuItem, Order, OrderStatus, Shop, User, UserStatus } from "@/types";

/**
 * Local store (localStorage). Every action maps 1:1 to a future REST endpoint,
 * e.g. placeOrder -> POST /orders, verifyPayment -> PATCH /orders/:id/payment.
 */
interface State {
  users: User[];
  shops: Shop[];
  menus: MenuItem[];
  orders: Order[];
  disputes: Dispute[];
  logs: ActivityLog[];
  cart: CartItem[];
}
const initial: State = { users: mock.users, shops: mock.shops, menus: mock.menus, orders: mock.orders, disputes: mock.disputes, logs: mock.logs, cart: [] };
const KEY = "kantinku-state-v1";
const now = () => new Date().toISOString();
const rid = (p: string) => `${p}-${Math.floor(1000 + Math.random() * 9000)}`;

function makeApi(set: (fn: (s: State) => State) => void, toast: (m: string) => void) {
  const log = (s: State, action: string, target: string): State => ({
    ...s,
    logs: [{ id: rid("l"), time: now(), admin: s.users.find((u) => u.id === mock.CURRENT.admin)?.name ?? "Admin", action, target, status: "success" }, ...s.logs],
  });
  const patchOrder = (id: string, p: Partial<Order>) => set((s) => ({ ...s, orders: s.orders.map((o) => (o.id === id ? { ...o, ...p } : o)) }));
  return {
    addToCart(menuId: string) {
      set((s) => {
        const menu = s.menus.find((m) => m.id === menuId)!;
        let cart = s.cart;
        const first = cart[0] && s.menus.find((m) => m.id === cart[0]!.menuId);
        if (first && first.shopId !== menu.shopId) cart = [];
        const ex = cart.find((c) => c.menuId === menuId);
        cart = ex ? cart.map((c) => (c.menuId === menuId ? { ...c, qty: c.qty + 1 } : c)) : [...cart, { menuId, qty: 1 }];
        return { ...s, cart };
      });
      toast("Menu ditambahkan ke keranjang");
    },
    setQty(menuId: string, qty: number) {
      set((s) => ({ ...s, cart: qty <= 0 ? s.cart.filter((c) => c.menuId !== menuId) : s.cart.map((c) => (c.menuId === menuId ? { ...c, qty } : c)) }));
    },
    placeOrder(p: { address: string; note: string; paymentMethod: string }) {
      const id = rid("ORD");
      set((s) => {
        const items = s.cart.map((c) => {
          const m = s.menus.find((x) => x.id === c.menuId)!;
          return { menuId: m.id, name: m.name, image: m.image, price: m.price, qty: c.qty };
        });
        const subtotal = items.reduce((a, b) => a + b.price * b.qty, 0);
        const shopId = s.menus.find((m) => m.id === s.cart[0]!.menuId)!.shopId;
        const order: Order = { id, trxId: rid("TRX"), buyerId: mock.CURRENT.buyer, shopId, items, subtotal, deliveryFee: 3000, total: subtotal + 3000, ...p, paymentStatus: "unpaid", status: "created", deliveryStatus: "waiting", createdAt: now() };
        return { ...s, orders: [order, ...s.orders], cart: [] };
      });
      return id;
    },
    submitPayment(id: string, proof: string, method: string) {
      patchOrder(id, { proof, paymentMethod: method, paymentStatus: "pending" });
      toast("Bukti pembayaran terkirim");
    },
    verifyPayment(id: string, ok: boolean) {
      patchOrder(id, ok ? { paymentStatus: "verified", status: "paid" } : { paymentStatus: "rejected", status: "cancelled" });
      toast(ok ? "Pembayaran diverifikasi" : "Pembayaran ditolak");
    },
    updateOrderStatus(id: string, status: OrderStatus) {
      patchOrder(id, { status });
      toast("Status pesanan diperbarui");
    },
    takeDelivery(id: string) {
      patchOrder(id, { driverId: mock.CURRENT.driver, deliveryStatus: "picked" });
      toast("Pengantaran diambil");
    },
    setDelivery(id: string, d: DeliveryStatus) {
      patchOrder(id, { deliveryStatus: d, ...(d === "onway" ? { status: "delivering" as const } : d === "done" ? { status: "done" as const } : {}) });
      toast("Status pengantaran diperbarui");
    },
    updateShop(id: string, p: Partial<Shop>) {
      set((s) => ({ ...s, shops: s.shops.map((x) => (x.id === id ? { ...x, ...p } : x)) }));
      toast("Informasi warung disimpan");
    },
    saveMenu(m: MenuItem) {
      set((s) => ({ ...s, menus: s.menus.some((x) => x.id === m.id) ? s.menus.map((x) => (x.id === m.id ? m : x)) : [...s.menus, m] }));
      toast("Menu disimpan");
    },
    deleteMenu(id: string) {
      set((s) => ({ ...s, menus: s.menus.filter((m) => m.id !== id) }));
      toast("Menu dihapus");
    },
    updateUser(id: string, p: Partial<User>) {
      set((s) => ({ ...s, users: s.users.map((u) => (u.id === id ? { ...u, ...p } : u)) }));
      toast("Profil disimpan");
    },
    setUserStatus(id: string, status: UserStatus) {
      set((s) => log({ ...s, users: s.users.map((u) => (u.id === id ? { ...u, status } : u)) }, status === "active" ? "Mengaktifkan pengguna" : "Menonaktifkan pengguna", `${s.users.find((u) => u.id === id)?.name} (${id})`));
      toast("Status pengguna diperbarui");
    },
    setSellerApproval(id: string, approval: Approval) {
      set((s) => log({ ...s, users: s.users.map((u) => (u.id === id ? { ...u, approval } : u)) }, approval === "approved" ? "Menyetujui penjual" : "Menolak penjual", `${s.users.find((u) => u.id === id)?.name} (${id})`));
      toast(approval === "approved" ? "Penjual disetujui" : "Penjual ditolak");
    },
    setShopApproval(id: string, approval: Approval) {
      set((s) => log({ ...s, shops: s.shops.map((x) => (x.id === id ? { ...x, approval } : x)) }, approval === "approved" ? "Menyetujui warung" : "Menolak warung", `${s.shops.find((x) => x.id === id)?.name} (${id})`));
      toast(approval === "approved" ? "Warung disetujui" : "Warung ditolak");
    },
    addDispute(d: { orderId: string; issue: string; description: string; proof?: string }) {
      set((s) => ({ ...s, disputes: [{ id: rid("DSP"), buyerId: mock.CURRENT.buyer, status: "open", createdAt: now(), ...d }, ...s.disputes] }));
      toast("Sengketa berhasil diajukan");
    },
    setDisputeStatus(id: string, status: DisputeStatus, resolution?: string) {
      set((s) => log({ ...s, disputes: s.disputes.map((d) => (d.id === id ? { ...d, status, resolution } : d)) }, "Memperbarui sengketa", id));
      toast("Sengketa diperbarui");
    },
  };
}

type Api = ReturnType<typeof makeApi>;
const Ctx = createContext<(Api & { state: State; toastMsg: string | null; reset: () => void }) | null>(null);

export function StoreProvider({ children }: { children: ReactNode }) {
  const [state, setState] = useState<State>(initial);
  const [loaded, setLoaded] = useState(false);
  const [toastMsg, setToast] = useState<string | null>(null);
  useEffect(() => {
    try {
      const raw = localStorage.getItem(KEY);
      if (raw) setState(JSON.parse(raw));
    } catch {}
    setLoaded(true);
  }, []);
  useEffect(() => {
    if (loaded) localStorage.setItem(KEY, JSON.stringify(state));
  }, [state, loaded]);
  const toast = useCallback((m: string) => {
    setToast(m);
    setTimeout(() => setToast(null), 2200);
  }, []);
  const api = useMemo(() => makeApi(setState, toast), [toast]);
  const reset = () => { setState(initial); toast("Data demo direset"); };
  return <Ctx.Provider value={{ ...api, state, toastMsg, reset }}>{children}</Ctx.Provider>;
}

export function useStore() {
  const c = useContext(Ctx);
  if (!c) throw new Error("useStore must be inside StoreProvider");
  return c;
}

export function useLookup() {
  const { state } = useStore();
  return {
    user: (id?: string) => state.users.find((u) => u.id === id),
    shop: (id?: string) => state.shops.find((s) => s.id === id),
    order: (id?: string) => state.orders.find((o) => o.id === id),
    me: (role: keyof typeof mock.CURRENT) => state.users.find((u) => u.id === mock.CURRENT[role])!,
  };
}
