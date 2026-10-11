export type Role = "admin" | "buyer" | "seller" | "driver";
export type Approval = "pending" | "approved" | "rejected";
export type UserStatus = "active" | "inactive";

export interface User {
  id: string;
  name: string;
  email: string;
  phone: string;
  role: Role;
  status: UserStatus;
  approval?: Approval;
  joined: string;
  avatar: string;
  address?: string;
}

export interface Shop {
  id: string;
  name: string;
  ownerId: string;
  description: string;
  image: string;
  location: string;
  hours: string;
  open: boolean;
  approval: Approval;
  submitted: string;
}

export interface MenuItem {
  id: string;
  shopId: string;
  name: string;
  description: string;
  category: string;
  price: number;
  image: string;
  available: boolean;
}

export interface OrderItem {
  menuId: string;
  name: string;
  image: string;
  price: number;
  qty: number;
}

export type PaymentStatus = "unpaid" | "pending" | "verified" | "rejected";
export type OrderStatus = "created" | "paid" | "processing" | "ready" | "delivering" | "done" | "cancelled";
export type DeliveryStatus = "waiting" | "picked" | "onway" | "done";

export interface Order {
  id: string;
  trxId: string;
  buyerId: string;
  shopId: string;
  items: OrderItem[];
  subtotal: number;
  deliveryFee: number;
  total: number;
  address: string;
  note: string;
  paymentMethod: string;
  paymentStatus: PaymentStatus;
  proof?: string;
  status: OrderStatus;
  driverId?: string;
  deliveryStatus: DeliveryStatus;
  createdAt: string;
}

export type DisputeStatus = "open" | "review" | "resolved" | "rejected";
export interface Dispute {
  id: string;
  orderId: string;
  buyerId: string;
  issue: string;
  description: string;
  proof?: string;
  status: DisputeStatus;
  resolution?: string;
  createdAt: string;
}

export interface ActivityLog {
  id: string;
  time: string;
  admin: string;
  action: string;
  target: string;
  status: "success" | "failed";
}

export interface CartItem {
  menuId: string;
  qty: number;
}
