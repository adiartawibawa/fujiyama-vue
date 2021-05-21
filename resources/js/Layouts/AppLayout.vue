<template>
  <div>
    <sidebar />

    <div class="relative md:ml-64 bg-blueGray-100">

      <admin-navbar />
      <!-- 
      <toast :toast="$page.props.flash" :popstate="$page.props.popstate" /> -->

      <!-- Header Stats -->
      <div class="relative bg-emerald-600 md:pt-32 pb-32 pt-12">

        <div class="px-4 md:px-10 mx-auto w-full">

          <div v-if="$slots.header">
            <!-- Card -->
            <slot name="header"></slot>
          </div>

        </div>
      </div>

      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <main>
          <slot></slot>
        </main>

        <footer-admin />
      </div>
    </div>

    <!-- Modal Portal -->
    <portal-target name="modal" multiple> </portal-target>
  </div>
</template>

<script>
import AdminNavbar from "@/Components/Navbars/AdminNavbar";
import Sidebar from "@/Components/Sidebar/Sidebar";
import FooterAdmin from "@/Components/Footers/FooterAdmin";
// import Toast from "@/Components/Alerts/Toast";

export default {
  name: "app-layout",
  components: {
    AdminNavbar,
    Sidebar,
    // Toast,
    FooterAdmin,
  },
};
</script>
