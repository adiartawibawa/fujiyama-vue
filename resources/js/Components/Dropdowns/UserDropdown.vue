<template>
  <div>
    <a class="text-blueGray-500 block" href="#" ref="btnDropdownRef" v-on:click="toggleDropdown($event)">
      <div class="items-center flex">
        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
          <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
        </button>

        <span v-else class="inline-flex rounded-md">
          <button type="button" class="inline-flex items-center px-3 py-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
            {{ $page.props.user.name }}

            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </span>
      </div>
    </a>
    <div ref="popoverDropdownRef" class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow
            }">
      <!-- Account Management -->
      <div class="block px-4 py-2 text-xs text-gray-400">
        Manage Account
      </div>

      <jet-dropdown-link :href="route('profile.show')">
        Profile
      </jet-dropdown-link>

      <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
        API Tokens
      </jet-dropdown-link>

      <div class="border-t border-gray-100"></div>

      <!-- Authentication -->
      <form @submit.prevent="logout">
        <jet-dropdown-link as="button">
          Logout
        </jet-dropdown-link>
      </form>
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

    logout() {
      this.$inertia.post(route("logout"));
    },
  },
};
</script>
