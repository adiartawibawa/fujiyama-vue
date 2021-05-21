<template>
  <app-layout>

    <template #header>
      <h1 class="text-white font-semibold text-lg">Roles and Permissions</h1>
    </template>

    <div class="flex flex-wrap">
      <div class="w-full mb-12">
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
          <div class="rounded-t mb-0 py-3 border-0">

            <!-- Content Page  -->
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6  rounded" :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
              <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                  <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <div class="text-center flex justify-between items-center">
                      <search-filter v-model="params.search" class="w-full max-w-md mr-4" @reset="reset">
                        <label class="block text-gray-700">Trashed:</label>
                        <select class="mt-1 w-full form-select">
                          <option :value="null" />
                          <option value="with">With Trashed</option>
                          <option value="only">Only Trashed</option>
                        </select>
                      </search-filter>
                      <inertia-link :href="route('role.create')" class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                        Add new
                      </inertia-link>
                    </div>
                  </div>
                </div>
              </div>

              <div class="block w-full overflow-x-auto shadow-md">
                <!-- Projects table -->
                <table class="items-center w-full bg-transparent border-collapse">
                  <thead>
                    <tr class="text-blueGray-800">
                      <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700', ]" @click="sort('id')">
                        <div class="inline-flex w-full items-center justify-start ">
                          #
                          <svg v-if="params.field === 'id' && params.direction === 'asc'" class="text-xs w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                          </svg>

                          <svg v-if="params.field === 'id' && params.direction === 'desc'" class="text-xs w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                          </svg>
                        </div>
                      </th>
                      <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700', ]" @click="sort('name')">
                        <div class="inline-flex w-full items-center justify-start ">
                          Role
                          <svg v-if="params.field === 'name' && params.direction === 'asc'" class="text-xs w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                          </svg>

                          <svg v-if="params.field === 'name' && params.direction === 'desc'" class="text-xs w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                          </svg>
                        </div>
                      </th>
                      <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700', ]">
                        Users
                      </th>
                      <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700', ]">
                        Permissions
                      </th>
                      <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700', ]"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, key) in roles.data" :key="key" class="text-blueGray-500">
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                        {{ item.id }}
                      </td>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                        {{ item.name }}
                      </td>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                        <div class="inline-flex align-middle">
                          <img v-for="(user, key) in item.users.slice(0,4)" :key="key" class="w-10 h-10 rounded-full border-2 border-blueGray-50 shadow" :class="{ '-ml-4' : key != 0 }" :src="user.profile_photo_url" :alt=" user.name" :title="user.name" />
                        </div>
                        <span v-if="item.users.length > 4 " class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none bg-gray-50 rounded-full -ml-4">+{{ item.users.length - 4 }}</span>
                      </td>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4 ml-4">
                        <span v-for="(permission, index) in item.permissions" :key="index" class="inline-flex items-center justify-center px-2 py-1 text-sm leading-none bg-gray-100 rounded-full">{{ permission }}</span>
                      </td>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4 text-right">
                        <action-dropdown :id="item.id" />
                      </td>
                    </tr>
                    <tr v-if=" roles.data.length === 0 ">
                      <td class="border px-6 py-4 text-center" colspan="5">
                        <span>No data found</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                  <div class="relative w-full max-w-full flex-grow flex-1">
                    <pagination :links="roles.meta.links" />
                  </div>
                </div>
              </div>

            </div>

            <!-- End Content Page -->
          </div>
        </div>
      </div>
    </div>

  </app-layout>
</template>

<script>
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

import AppLayout from "@/Layouts/AppLayout";
import SearchFilter from "@/Components/DataTables/SearchFilter";
import Pagination from "@/Components/DataTables/Pagination";
import ActionDropdown from "@/Components/DataTables/ActionDropdown";
import EmptyData from "@/Components/Illustrations/Empty";

export default {
  name: "index-role",

  props: {
    roles: Object,
    filters: Object,
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
  },

  data() {
    return {
      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
      },
    };
  },

  components: {
    AppLayout,
    EmptyData,
    SearchFilter,
    Pagination,
    ActionDropdown,
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("role.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },

  methods: {
    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },

    reset() {
      this.params = mapValues(this.params, () => null);
    },
  },
};
</script>

<style scoped>
</style>