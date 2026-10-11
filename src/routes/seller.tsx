import { createFileRoute, Outlet } from "@tanstack/react-router";
import { AppShell } from "@/components/layout/AppShell";

export const Route = createFileRoute("/seller")({
  component: () => (
    <AppShell role="seller">
      <Outlet />
    </AppShell>
  ),
});
