<template>
  <app-layout>

    <template #header>
      <h1 class="text-white font-semibold text-lg">Create New User</h1>
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
                    Basic Info
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
                          Email Address
                        </label>
                        <input v-model="form.email" type="email" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                      </div>
                    </div>
                  </div>

                  <hr class="mt-6 border-b-1 border-blueGray-300" />

                  <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Credentials
                  </h6>
                  <div class="flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                          Password
                        </label>
                        <input v-model="form.password" type="password" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                      </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                          Re-Type Password
                        </label>
                        <input v-model="form.password_confirmation" type="password" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                      </div>
                    </div>
                  </div>

                  <hr class="mt-6 border-b-1 border-blueGray-300" />

                  <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Role
                  </h6>
                  <div class="flex flex-wrap">
                    <div class="w-full px-4">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                          Assign user a role
                        </label>
                        <multiselect v-model="form.roles" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="options" :searchable="false" :allow-empty="false">
                          <template slot="singleLabel" slot-scope="{ option }">{{ option.name }}</template>
                        </multiselect>
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
    roles: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        roles: [],
      }),
      showModalPermission: false,
      options: this.roles.data,
    };
  },

  methods: {
    store() {
      this.form.post(this.route("user.store"), {
        onFinish: () => this.form.reset(),
      });
    },

    showingModalPermission() {
      this.showModalPermission = true;
    },
    closeModal() {
      this.showModalPermission = false;

      this.formPermission.reset();
    },
  },
};
</script>

<style scoped>
</style>