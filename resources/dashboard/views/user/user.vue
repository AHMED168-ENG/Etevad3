<template>
  <div class="users">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'اضافه مستخدم'
                  )
                "
                @click="createUser"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه مستخدم
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل المستخدمين'
                  )
                "
                href="/user/excel"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-success btn-block"
                >تحميل اكسل <i class="fas fa-download"></i
              ></a>
            </div>
          </div>
          <div class="card-body">
            <form class="form_search_box">
              <button @click.prevent="" title="Search" class="button">
                <i class="fas fa-search"></i>
              </button>

              <input
                @input="searchUser"
                type="text"
                class="textbox"
                placeholder="Search"
              />
            </form>
            <div class="table-responsive">
              <table
                class="table table-striped nowrap"
                style="text-align: center; width: 100%"
              >
                <thead>
                  <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">الاسم</th>
                    <th class="border-bottom-0">الايميل</th>
                    <th class="border-bottom-0">الصلاحيه</th>
                    <th class="border-bottom-0">العمر</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in users.data" :key="index">
                    <td>{{ user.id }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="table-td-image">
                          <img
                            :src="
                              user.image
                                ? '/images/user/' + user.image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        {{ user.name }}
                      </div>
                    </td>
                    <td>{{ user.email }}</td>
                    <td>
                      <span class="badge bg-success">{{
                        user.roles[0].name
                      }}</span>
                    </td>
                    <td>
                      {{ user.age ? user.age : "فارغ" }}
                    </td>
                    <td>
                      <span v-if="user.status == 1" class="label text-success">
                        active</span
                      >
                      <span v-if="user.status == 0" class="label text-danger">
                        not active</span
                      >
                    </td>

                    <td>
                      <div class="dropdown" style="text-align: left">
                        <button
                          aria-expanded="false"
                          aria-haspopup="true"
                          class="btn ripple btn-primary btn-sm d-flex"
                          data-toggle="dropdown"
                          type="button"
                        >
                          العمليات
                          <i class="fas fa-caret-down ml-1"></i>
                        </button>
                        <div class="dropdown-menu tx-13">
                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'تعديل مستخدم'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editUser(user)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف مستخدم'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteUser(user.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله المستخدم'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeUser(user.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{ user.status == "1" ? "الغاء التفعيل" : "تفعيل" }}
                          </button>

                          <!-- <a
                                                        class="dropdown-item"
                                                        href="#"
                                                        data-invoice_id="{{ $invoice->id }}"
                                                        data-toggle="modal"
                                                        data-target="#Transfer_invoice"
                                                        ><i
                                                            class="text-warning fas fa-exchange-alt"
                                                        ></i
                                                        >&nbsp;&nbsp;نقل الي
                                                        الارشيف</a
                                                    > -->

                          <router-link
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'تفاصيل المستخدم'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/users/' + user.id"
                            ><i class="text-success fas fa-eye"></i
                            >&nbsp;&nbsp;عرض البيانات</router-link
                          >
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <VPagination
            v-model="page"
            :pages="users.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getUsers"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.user.edit ? "تعديل" : "انشاء" }}
                </h6>
                <button
                  aria-label="Close"
                  class="close"
                  data-dismiss="modal"
                  type="button"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form
                autocomplete="on"
                action=""
                @submit="
                  (e) => {
                    e.preventDefault();
                  }
                "
              >
                <div class="modal-body">
                  <div class="form-contole">
                    <label class="form-controle">اسم المستخدم</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.name ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="user.data.name"
                    />
                    <span v-if="user.errors.name" class="invalid-feedback">
                      {{ user.errors.name[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">ايميل المستخدم</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.email ? 'is-invalid' : '',
                      ]"
                      type="email"
                      v-model="user.data.email"
                    />
                    <span v-if="user.errors.email" class="invalid-feedback">
                      {{ user.errors.email[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">الرقم السري</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.password ? 'is-invalid' : '',
                      ]"
                      type="password"
                      v-model="user.data.password"
                    />
                    <span v-if="user.errors.password" class="invalid-feedback">
                      {{ user.errors.password[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">الموبايل</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.mobile ? 'is-invalid' : '',
                      ]"
                      type="number"
                      v-model="user.data.mobile"
                    />
                    <span v-if="user.errors.mobile" class="invalid-feedback">
                      {{ user.errors.mobile[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">العنوان</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.addres ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="user.data.addres"
                    />
                    <span v-if="user.errors.addres" class="invalid-feedback">
                      {{ user.errors.addres[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">العمر</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        user.errors.age ? 'is-invalid' : '',
                      ]"
                      type="number"
                      v-model="user.data.age"
                    />
                    <span v-if="user.errors.age" class="invalid-feedback">
                      {{ user.errors.age[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-label">الصلاحيه </label>
                    <select
                      v-model="user.data.role"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option
                        v-for="(role, index) in roles"
                        :key="index"
                        :value="role.name"
                      >
                        {{ role.name }}
                      </option>
                    </select>
                    <span v-if="user.errors.role" class="invalid-feedback">
                      {{ user.errors.role[0] }}
                    </span>
                  </div>

                  <div v-if="user.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="user.data.status"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="user.errors.status" class="invalid-feedback">
                      {{ user.errors.status[0] }}
                    </span>
                  </div>

                  <div v-if="!user.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="user.data.status"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="user.errors.status" class="invalid-feedback">
                      {{ user.errors.status[0] }}
                    </span>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    الغاء
                  </button>

                  <button
                    v-if="user.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateUser"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!user.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveUser"
                  >
                    انشاء
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  name: "permisionPage",
  editor: ClassicEditor,
  editorData: "",
  editorConfig: {
    toolbar: [
      "heading",
      "|",
      "bold",
      "italic",
      "link",
      "bulletedList",
      "numberedList",
      "blockQuote",
    ],
    heading: {
      options: [
        {
          model: "paragraph",
          title: "Paragraph",
          class: "ck-heading_paragraph",
        },
        {
          model: "heading1",
          view: "h1",
          title: "Heading 1",
          class: "ck-heading_heading1",
        },
        {
          model: "heading2",
          view: "h2",
          title: "Heading 2",
          class: "ck-heading_heading2",
        },
      ],
    },
  },
  name: "UserPage",
  data: () => {
    return {
      page: 1,
      search: "",
      users: {},
      roles: [],
      user: {
        edit: false,
        data: {
          name: "",
          email: "",
          password: "",
          status: 1,
          addres: "",
          mobile: "",
          role: "",
          age: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit user =======================
    editUser(user) {
      this.user.errors = {};
      this.user.edit = true;
      this.user.data = user;
      this.user.data.role = user.roles[0].name;
    },
    // ================= end part edit user =======================
    // ================= start part update user =======================
    updateUser() {
      axios
        .put("/api/admin/user/update/" + this.user.data.id, this.user.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات المستخدم بنجاح",
            });
            this.user.errors = {};
            this.getUsers();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.user.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update user =======================
    // ================= start part create user =======================
    createUser() {
      this.resetEventData();
      this.user.edit = false;
    },
    // ================= end part create user =======================
    // ================= start reset event =======================
    resetEventData() {
      this.user.data = {
        name: "",
        role: "",
        email: "",
        password: "",
        status: 1,
        addres: "",
        mobile: "",
        age: "",
      };
      this.user.errors = {};
    },
    // ================= end reset event =======================
    // ================= start part save user =======================
    saveUser() {
      axios
        .post("/api/admin/user/store", this.user.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء المستخدم بنجاح",
            });
            this.resetEventData();
            this.getUsers();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.user.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save user =======================
    // ================= start part delete user =======================
    deleteUser(postId) {
      Swal.fire({
        title: "هل انتا متاكد !؟",
        text: "لن تتمكن من ارجاع البيانات مره اخري",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      })
        .then((result) => {
          if (result.isConfirmed) {
            axios.delete("/api/admin/user/delete/" + postId).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "user has been deleted.", "success");
                this.getUsers();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.user.errors = result.data.errors;
              }
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part delete user =======================
    // ================= start part get users with pagination =======================
    getUsers(page = this.page) {
      axios
        .get(
          "/api/admin/user/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.users = res.data.users;
          } else if (res.data.status == null) {
            Toast.fire({
              icon: "error",
              title: res.data.error,
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part get users with pagination =======================
    // ================= start part get roles with pagination =======================
    getRoles() {
      axios
        .get("/api/admin/role/all")
        .then((res) => {
          if (res.data.status == true) {
            this.roles = res.data.roles;
          } else if (res.data.status == null) {
            Toast.fire({
              icon: "error",
              title: res.data.error,
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part get roles with pagination =======================
    // ================= start part active user =======================
    activeUser(id) {
      axios
        .put("/api/admin/user/activation/" + id, this.user.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل المستخدم بنجاح"
                  : "تم الغاء تفعيل المستخدم بنجاح",
            });
            this.getUsers();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save user =======================

    searchUser(e) {
      let search = e.target.value;
      this.search = search;
      this.getUsers();
    },
  },
  created() {
    this.getRoles();
    this.getUsers();
  },
};
</script>

<style lang="scss" scoped>
.users {
  .modal-body {
    div.form-contole {
      margin-bottom: 15px;
    }
  }
}
.Pagination {
  margin: 0 auto 10px;
}
</style>
