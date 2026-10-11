import { useStore } from "@/lib/store";

export function useCartLines() {
  const { state } = useStore();
  const lines = state.cart.map((c) => ({ ...c, menu: state.menus.find((m) => m.id === c.menuId)! })).filter((l) => l.menu);
  const subtotal = lines.reduce((a, l) => a + l.menu.price * l.qty, 0);
  const shop = lines[0] && state.shops.find((s) => s.id === lines[0]!.menu.shopId);
  return { lines, subtotal, shop, fee: lines.length ? 3000 : 0 };
}

