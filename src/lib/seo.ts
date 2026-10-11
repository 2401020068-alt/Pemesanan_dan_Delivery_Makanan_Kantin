export const seo = (title: string, description: string) => ({
  meta: [
    { title: `${title} | KantinKu` },
    { name: "description", content: description },
    { property: "og:title", content: `${title} | KantinKu` },
    { property: "og:description", content: description },
  ],
});
