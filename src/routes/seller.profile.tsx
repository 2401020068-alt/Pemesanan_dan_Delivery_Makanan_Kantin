import { createFileRoute } from "@tanstack/react-router";
import { ProfileView } from "@/components/forms/ProfileView";
import { seo } from "@/lib/seo";

export const Route = createFileRoute("/seller/profile")({
  head: () => seo("Profil", "Informasi dan pengaturan akun."),
  component: () => <ProfileView role="seller" />,
});
