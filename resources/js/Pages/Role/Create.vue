<template>
  <app-layout>

    <template #header>
      Create new role
    </template>

    <div class="flex flex-wrap">
      <div class="w-full mb-12">
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
          <div class="rounded-t mb-0 py-3 border-0">

            <!-- Content Page Goes Here -->
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
              <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-end">
                  <jet-button @click.native="store" class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="submit">
                    Save
                  </jet-button>
                </div>
              </div>
              <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                <form>
                  <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Role
                  </h6>
                  <div class="flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                          Name
                        </label>
                        <input v-model="form.name" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required autofocus autocomplete="name" />
                      </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                          Slug
                        </label>
                        <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" :value="slug" disabled />
                      </div>
                    </div>
                  </div>

                  <hr class="mt-6 border-b-1 border-blueGray-300" />

                  <h6 class=" text-center flex justify-between text-blueGray-400 text-sm mt-3 mb-6">
                    <div class="text-left">
                      <span class="uppercase font-bold">Permissions</span>
                      <p class="lowercase text-xs text-blueGray-400">Enable or disable permissions and choose access to modules.</p>
                    </div>
                    <jet-button class="uppercase" type="button" @click.native="showingModalPermission">
                      Add new permission
                    </jet-button>
                    <!-- Adding New Permission Modal -->
                    <jet-modal :show="showModalPermission" @close="closeModal">
                      <template #title>
                        Add New Permission
                      </template>
                      <template #content>
                        <div>
                          <jet-label for="name" value="New Permission" />
                          <jet-input id="name" type="text" class="mt-1 block w-full" v-model="formPermission.name" required autofocus autocomplete="name" />
                        </div>
                      </template>
                      <template #footer>
                        <jet-button type="submit" class="ml-4" @click.native="savePermission">
                          Add Permission
                        </jet-button>
                        <jet-secondary-button @click.native="closeModal">
                          Cancel
                        </jet-secondary-button>
                      </template>
                    </jet-modal>
                    <!-- End Permission Modal -->
                  </h6>
                  <div class="flex flex-wrap">
                    <div class="w-full lg:w-12/12 px-4">
                      <div class="relative w-full mb-3">
                        <ul class="flex flex-wrap">
                          <li v-for="permission in permissions.data" :key="permission.id">
                            <label class="inline-flex items-center mt-3 mr-3">
                              <input type="checkbox" :value="permission.name" :id="permission.id" v-model="form.permissions" class="form-checkbox h-3 w-3 text-emerald-600">
                              <span class="ml-1 text-gray-700">{{ permission.name }}</span>
                            </label>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </form>
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
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetModal from "@/Jetstream/DialogModal";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  name: "role-new",

  components: {
    AppLayout,
    JetInput,
    JetLabel,
    JetButton,
    JetModal,
    JetSecondaryButton,
  },

  props: {
    permissions: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        permissions: [],
      }),
      formPermission: this.$inertia.form({
        name: "",
      }),
      showModalPermission: false,
    };
  },

  computed: {
    slug: function () {
      var slug = this.sluggable(this.form.name);
      return slug;
    },
  },

  methods: {
    store() {
      this.form.post(this.route("role.store"), {
        onFinish: () => this.form.reset(),
      });
    },
    savePermission() {
      this.formPermission.post(this.route("permission.store"), {
        onFinish: () => this.formPermission.reset(),
      });
      this.closeModal();
    },
    showingModalPermission() {
      this.showModalPermission = true;
    },
    closeModal() {
      this.showModalPermission = false;

      this.formPermission.reset();
    },
    sluggable(title) {
      var slug = "";
      // Change to lower case
      var titleLower = title.toLowerCase();
      // Letter "e"
      slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, "e");
      // Letter "a"
      slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, "a");
      // Letter "o"
      slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, "o");
      // Letter "u"
      slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, "u");
      // Letter "d"
      slug = slug.replace(/đ/gi, "d");
      // Trim the last whitespace
      slug = slug.replace(/\s*$/g, "");
      // Change whitespace to "-"
      slug = slug.replace(/\s+/g, "-");

      return slug;
    },
  },
};
</script>

<style scoped>
</style>