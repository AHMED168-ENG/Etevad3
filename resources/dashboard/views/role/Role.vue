<template>
  <div class="role">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'اضافه صلاحيه'
                  )
                "
                @click="createRole"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه صلاحيه
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل صلاحيه'
                  )
                "
                href="/role/excel"
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
                @input="searchRole"
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
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(role, index) in AllRoles.data" :key="index">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>

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
                          <!-- <button
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editRole(role)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button> -->

                          <!-- <button
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteRole(role.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button> -->

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
                                'تفاصيل الصلاحيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/role/' + role.id"
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
            :pages="AllRoles.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getRole"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.role.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">اسم الصلاحيه</label>

                    <select
                      v-model="role.data.name"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="">اختر الصلاحيه</option>
                      <option value="Super Admin">سوبر ادمن</option>
                      <option value="Admin">ادمن</option>
                    </select>
                    <span v-if="role.errors.name" class="invalid-feedback">
                      {{ role.errors.name[0] }}
                    </span>
                  </div>
                  <hr />
                  <div class="form-contole">
                    <label class="form-controle my-0">اذونات الصلاحيه</label>
                    <hr />
                    <div class="row">
                      <div
                        v-for="(permission, index) in AllPermissions"
                        :key="index"
                        class="col-md-3"
                      >
                        <input
                          type="checkbox"
                          :value="permission"
                          v-model="role.data.permissions"
                          :id="index"
                        />
                        <label :for="index"> {{ permission }} </label>
                      </div>
                    </div>
                    <span
                      v-if="role.errors.permissions"
                      class="invalid-feedback"
                    >
                      {{ role.errors.permissions[0] }}
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
                    v-if="role.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateRole"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!role.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveRole"
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
  name: "rolePage",
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

  data: () => {
    return {
      search: "",
      page: 1,
      AllRoles: {},
      AllPermissions: [],
      role: {
        // edit: false,
        data: {
          id: "",
          name: "",
          permissions: [],
        },
        errors: [],
      },
    };
  },
  methods: {
    // // ================= end part edit role =======================
    // editRole(role) {
    //   this.role.edit = true;
    //   this.role.data = role;
    // },
    // // ================= end part edit role =======================
    // ================= start part update role =======================
    updateRole() {
      axios
        .put("/api/admin/role/update/" + this.role.data.id, this.role.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الصلاحيه بنجاح",
            });
            this.role.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.role.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update role =======================
    // ================= start part create role =======================
    createRole() {
      this.role.edit = false;
      this.resetRoleData();
    },
    // ================= end part create role =======================
    // ================= start reset role =======================
    resetRoleData() {
      this.role.data = {
        id: "",
        name: "",
        permissions: [],
      };
    },
    // ================= end reset role =======================
    // ================= start part save role =======================
    saveRole() {
      axios
        .post("/api/admin/role/store", this.role.data, {})
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الصلاحيه بنجاح",
            });
            this.role.errors = {};
            this.resetRoleData();
            this.getRole();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.role.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save role =======================
    // ================= start part delete role =======================
    // deleteRole(id) {
    //   Swal.fire({
    //     title: "Are you sure?",
    //     text: "You won't be able to revert this!",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes, delete it!",
    //   })
    //     .then((result) => {
    //       if (result.isConfirmed) {
    //         axios.delete("/api/admin/role/delete/" + id).then((result) => {
    //           if (result.data.status == true) {
    //             Swal.fire("Deleted!", "تم حذف الصلاحيه", "success");
    //             this.getRole();
    //           } else if (result.data.status == null) {
    //             Toast.fire({
    //               icon: "error",
    //               title: result.data.error,
    //             });
    //           } else {
    //             this.role.errors = result.data.errors;
    //           }
    //         });
    //       }
    //     })
    //     .catch((error) => {
    //       Toast.fire({
    //         icon: "error",
    //         title: error,
    //       });
    //     });
    // },
    // ================= end part delete role =======================
    // ================= start part get permisions with pagination =======================
    getPermissions() {
      axios
        .get("/api/admin/permission/all?")
        .then((res) => {
          if (res.data.status == true) {
            this.AllPermissions = res.data.permissions.map((ele) => ele.name);
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
    // ================= end part get permisions with pagination =======================
    // ================= start part get role with pagination =======================
    getRole(page = this.page) {
      axios
        .get(
          "/api/admin/role/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllRoles = res.data.roles;
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
    // ================= end part get role with pagination =======================

    searchRole(e) {
      let search = e.target.value;
      this.search = search;
      this.getRole();
    },
  },
  created() {
    this.getPermissions();
    this.getRole();
  },
};
</script>

<style lang="scss" scoped>
.role {
  .clamp {
    p {
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
  }
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
