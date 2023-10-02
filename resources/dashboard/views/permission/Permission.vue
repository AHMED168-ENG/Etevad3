<template>
  <div class="role">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <!-- <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه اذون')
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
                اضافه اذون
              </button> -->
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل اذون'
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
                @input="searchPermission"
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
                    <!-- <th class="border-bottom-0">العمليات</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(permission, index) in AllPermissions.data"
                    :key="index"
                  >
                    <td>{{ permission.id }}</td>
                    <td>{{ permission.name }}</td>

                    <!-- <td>
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
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteRole(role.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <a
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
                            >

                          <router-link
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/role/' + role.id"
                            ><i class="text-success fas fa-eye"></i
                            >&nbsp;&nbsp;عرض البيانات</router-link
                          >
                        </div>
                      </div>
                    </td> -->
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <VPagination
            v-model="page"
            :pages="AllPermissions.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getPermissions"
          ></VPagination>
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
  data: () => {
    return {
      page: 1,
      search: "",
      AllPermissions: {},
    };
  },
  methods: {
    // ================= start part get permisions with pagination =======================
    getPermissions(page = this.page) {
      axios
        .get(
          "/api/admin/permission/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllPermissions = res.data.permissions;
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
    searchPermission(e) {
      let search = e.target.value;
      this.search = search;
      this.getPermissions();
    },
  },
  created() {
    this.getPermissions();
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
