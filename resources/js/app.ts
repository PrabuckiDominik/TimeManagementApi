import { createApp } from "vue"
// @ts-ignore
import App from "@/App.vue"

import { router } from "@/presentation/router"
import { i18n } from "@/shared/i18n"

createApp(App)
  .use(router)
  .use(i18n)
  .mount("#app")
