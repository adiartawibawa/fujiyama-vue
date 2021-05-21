<template>
  <inertia-link :href="href" class="text-xs uppercase py-3 font-bold block" :class="classes">
    <slot></slot>
  </inertia-link>
</template>

<script>
export default {
  props: ["href", "active"],

  computed: {
    classes() {
      return this.active
        ? "text-emerald-500 hover:text-emerald-600"
        : "text-blueGray-700 hover:text-blueGray-500";
    },
  },
};
</script>
