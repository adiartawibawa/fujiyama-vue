<template>
  <transition name="slide-fade">
    <div v-if="toast && toastOpen && !popstate" class="absolute z-50 top-0 right-0 rounded px-6 py-4 border-0  mb-4 max-w-xs mt-4 mr-4 shadow p-4" :class="classBg">
      <div class="text-xl inline-block mr-5 align-middle">
        <i class="fas" :class="classIcon"></i>
      </div>
      <div class="inline-block align-middle mr-8">
        {{ toast.message.message }}
      </div>
      <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none focus:text-indigo-600 hover:text-blueGray-700" v-on:click="closeToast()">
        <span>×</span>
      </button>
    </div>
  </transition>
</template>

<script>
export default {
  name: "toast",
  props: {
    toast: Object,
    popstate: Boolean,
  },
  data() {
    return {
      toastOpen: false,
      timeOut: null,
    };
  },
  watch: {
    toast: {
      deep: true,
      handler() {
        this.toastOpen = true;

        if (this.timeOut) {
          clearTimeout(this.timeOut);
        }

        this.timeOut = setTimeout(() => (this.toastOpen = false), 1000);
      },
    },
  },

  computed: {
    classBg() {
      switch (this.toast.message.type) {
        case "success":
          return "bg-emerald-200  text-white ";
          break;
        case "error":
          return "bg-red-200  text-white ";
          break;
        case "warning":
          return "bg-yellow-200  text-white ";
          break;
        case "info":
          return "bg-blue-200  text-white ";
          break;
        default:
          return "bg-white  text-blueGray-600 ";
      }
    },

    classIcon() {
      switch (this.toast.message.type) {
        case "success":
          return "fa-check-circle";
          break;
        case "error":
          return "fa-bug";
          break;
        case "warning":
          return "fa-exclamation-circle";
          break;
        case "info":
          return "fa-info-circle";
          break;
        default:
          return "fa-bell";
      }
    },
  },

  methods: {
    closeToast: function () {
      this.toastOpen = false;
    },
  },
};
</script>

<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(150px);
  opacity: 0;
}
</style>