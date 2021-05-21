<template>
  <div v-if="$page.props.jetstream.hasTeamFeatures">
    <a class="text-blueGray-500 block" href="#" ref="btnDropdownRef" v-on:click="toggleDropdown($event)">
      <div class="items-center flex">
        <button type="button" class="inline-flex items-center px-3 py-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
          {{ $page.props.user.current_team.name }}

          <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </a>
    <div ref="popoverDropdownRef" class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow
            }">
      <div class="block px-4 py-2 text-xs text-gray-400">
        Manage Team
      </div>

      <!-- Team Settings -->
      <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
        Team Settings
      </jet-dropdown-link>

      <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
        Create New Team
      </jet-dropdown-link>

      <div class="border-t border-gray-100"></div>

      <!-- Team Switcher -->
      <div class="block px-4 py-2 text-xs text-gray-400">
        Switch Teams
      </div>

      <template v-for="team in $page.props.user.all_teams">
        <form @submit.prevent="switchToTeam(team)" :key="team.id">
          <jet-dropdown-link as="button">
            <div class="flex items-center">
              <svg v-if="
                                    team.id == $page.props.user.current_team_id
                                " class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div>{{ team.name }}</div>
            </div>
          </jet-dropdown-link>
        </form>
      </template>
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

    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },
  },
};
</script>
