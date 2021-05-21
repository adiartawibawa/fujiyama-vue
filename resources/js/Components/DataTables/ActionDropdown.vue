<template>
  <div>
    <a class="text-blueGray-500 py-1 px-3" href="#pablo" ref="btnDropdownRef" v-on:click="toggleDropdown($event)">
      <i class="fas fa-ellipsis-v"></i>
    </a>
    <div ref="popoverDropdownRef" class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow
            }">

      <jet-dropdown-link href="#" @click.native="editItem(id)">
        <i class="fas fa-pencil-alt"></i> Edit
      </jet-dropdown-link>

      <jet-dropdown-link href="#" @click.native="deleteItem(id)">
        <i class="far fa-trash-alt"></i> Delete
      </jet-dropdown-link>

    </div>
  </div>
</template>
<script>
import { createPopper } from "@popperjs/core";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";

export default {
  components: {
    JetDropdownLink,
  },
  props: {
    id: Number,
  },
  data() {
    return {
      dropdownPopoverShow: false,
    };
  },
  methods: {
    toggleDropdown: function (event) {
      event.preventDefault();
      if (this.dropdownPopoverShow) {
        this.dropdownPopoverShow = false;
      } else {
        this.dropdownPopoverShow = true;
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start",
        });
      }
    },

    editItem(id) {
      let str = window.location.pathname;
      let url = str.split("/");
      this.$inertia.get(url[1] + "/" + id + "/edit");
    },

    deleteItem(id) {
      let str = window.location.pathname;
      let url = str.split("/");
      if (confirm("Are you sure you want to delete this item?")) {
        this.$inertia.delete(url[1] + "/" + id);
      }
    },
  },
};
</script>
