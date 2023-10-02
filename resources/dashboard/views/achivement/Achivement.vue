<template>
  <div class="achivement">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه انجاز')
                "
                @click="createAchivement"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه انجاز
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل الانجاز'
                  )
                "
                href="/achivement/excel"
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
                @input="searchAchivement"
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
                    <th class="border-bottom-0">العنوان</th>
                    <th class="border-bottom-0">تاريخ الانجاز</th>
                    <th class="border-bottom-0">نوع الانجاز</th>
                    <th class="border-bottom-0">القسم الخاص بالانجاز</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(achivement, index) in AllAchivement.data"
                    :key="index"
                  >
                    <td>{{ achivement.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              achivement.achivement_image
                                ? '/images/achivement/images/' +
                                  achivement.achivement_image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p v-html="achivement.title"></p>
                      </div>
                    </td>
                    <td>
                      <p>
                        {{ formateDate(achivement.achivement_date).date }}
                      </p>
                    </td>
                    <td>
                      {{ achivement.achivement_kind }}
                    </td>
                    <td>
                      <span
                        :class="[
                          'badge badge-pill',
                          achivement.achivement_category == 1
                            ? 'badge-info'
                            : 'badge-warning',
                        ]"
                        >{{
                          achivement.achivement_category == 1
                            ? "الروبوت"
                            : "الرياضات اللاسلكيه"
                        }}</span
                      >
                    </td>
                    <td>
                      <span
                        v-if="achivement.active == 1"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span
                        v-if="achivement.active == 0"
                        class="label text-danger"
                      >
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
                                'تعديل انجاز'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editAchivement(achivement)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف انجاز'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteAchivement(achivement.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله الانجاز'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeachivement(achivement.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              achivement.active == 1 ? "الغاء التفعيل" : "تفعيل"
                            }}
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
                                'تفاصيل الانجاز'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/achivement/' + achivement.id"
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
            :pages="AllAchivement.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getAchivement"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.achivement.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">عنوان الانجاز</label>
                    <textarea
                      :class="[
                        'form-control',
                        achivement.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="achivement.data.title"
                    >
                    </textarea>
                    <span
                      v-if="achivement.errors.title"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.title[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">تاريخ الانجاز</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        achivement.errors.achivement_date ? 'is-invalid' : '',
                      ]"
                      type="date"
                      v-model="achivement.data.achivement_date"
                    />
                    <span
                      v-if="achivement.errors.achivement_date"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.achivement_date[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">محتوي الانجاز</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        achivement.errors.content ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="achivement.data.content"
                      :config="editorConfig"
                    ></ckeditor>
                    <span
                      v-if="achivement.errors.content"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.content[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">نوع الانجاز</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        achivement.errors.achivement_kind ? 'is-invalid' : '',
                      ]"
                      v-model="achivement.data.achivement_kind"
                    />
                    <span
                      v-if="achivement.errors.achivement_kind"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.achivement_kind[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">قسم الانجاز</label>
                    <select
                      v-model="achivement.data.achivement_category"
                      id="select-beast"
                      :class="[
                        'form-control',
                        'custom-select',
                        'nice-select',
                        achivement.errors.achivement_category
                          ? 'is-invalid'
                          : '',
                      ]"
                    >
                      <option value="1">الروبوت</option>
                      <option value="2">الرياضات اللاسلكيه</option>
                    </select>

                    <span
                      v-if="achivement.errors.achivement_category"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.achivement_category[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle"
                      >الوصف الخاص بالصفحه (سيو)</label
                    >
                    <textarea
                      autocomplete="on"
                      :class="[
                        'form-control',
                        achivement.errors.page_description ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="achivement.data.page_description"
                    ></textarea
                    >
                    <span
                      v-if="achivement.errors.page_description"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.page_description[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle"
                      >الكلمات الوصفيه الخاص بالصفحه مفصوله , (سيو)</label
                    >
                    <textarea
                      autocomplete="on"
                      :class="[
                        'form-control',
                        achivement.errors.page_keywords ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="achivement.data.page_keywords"
                    ></textarea>
                    <span
                      v-if="achivement.errors.page_keywords"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.page_keywords[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!achivement.edit">
                    <label class="form-controle">صوره الانجاز</label>
                    <div class="input-group mb-3">
                      <input
                        type="file"
                        class="form-control"
                        id="inputGroupFile02"
                        @change="setAchivement_image"
                      />
                      <label class="input-group-text" for="inputGroupFile02"
                        >Upload</label
                      >
                    </div>
                    <span
                      v-if="achivement.errors.achivement_image"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ achivement.errors.achivement_image[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!achivement.edit">
                    <label class="form-controle">
                      اللوجو الخاص بنوع الانجاز</label
                    >
                    <div class="input-group mb-3">
                      <input
                        type="file"
                        class="form-control"
                        id="inputGroupFile02"
                        @change="setAchivement_icon"
                      />
                      <label class="input-group-text" for="inputGroupFile02"
                        >Upload</label
                      >
                    </div>
                    <span
                      v-if="achivement.errors.achivement_icon"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ achivement.errors.achivement_icon[0] }}
                    </span>
                  </div>

                  <div v-show="achivement.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="achivement.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="achivement.errors.active"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!achivement.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="achivement.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="achivement.errors.active"
                      class="invalid-feedback"
                    >
                      {{ achivement.errors.active[0] }}
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
                    v-if="achivement.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateAchivement"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!achivement.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveAchivement"
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
  name: "achivementPage",
  data: () => {
    return {
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
            {
              model: "heading3",
              view: "h3",
              title: "Heading 3",
              class: "ck-heading_heading3",
            },
            {
              model: "heading4",
              view: "h4",
              title: "Heading 4",
              class: "ck-heading_heading4",
            },
          ],
        },
      },
      page: 1,
      search: "",
      AllAchivement: {},
      achivement: {
        edit: false,
        data: {
          id: "",
          title: "",
          achivement_date: "",
          content: "",
          achivement_kind: "",
          achivement_image: "",
          achivement_icon: "",
          achivement_category: "",
          active: 1,
          page_description: "",
          page_keywords: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit achivement =======================
    editAchivement(achivement) {
      achivement.achivement_date = moment(achivement.achivement_date).format(
        "YYYY-MM-DD"
      );
      this.achivement.edit = true;
      this.achivement.data = achivement;
      this.event.errors = {};
    },
    // ================= end part edit achivement =======================
    // ================= start part update achivement =======================
    updateAchivement() {
      axios
        .put(
          "/api/admin/achivement/update/" + this.achivement.data.id,
          this.achivement.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الانجاز بنجاح",
            });
            this.achivement.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.achivement.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update achivement =======================
    // ================= start part create achivement =======================
    createAchivement() {
      this.achivement.edit = false;
      this.resetAchivementData();
    },
    // ================= end part create achivement =======================
    // ================= start reset achivement =======================
    resetAchivementData() {
      this.achivement.data = {
        id: "",
        title: "",
        achivement_date: "",
        content: "",
        achivement_kind: "",
        achivement_image: "",
        achivement_icon: "",
        achivement_category: "",
        active: 1,
        page_description: "",
        page_keywords: "",
      };
    },
    // ================= end reset achivement =======================
    // ================= start part save achivement =======================
    saveAchivement() {
      axios
        .post("/api/admin/achivement/store", this.achivement.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الانجاز بنجاح",
            });
            this.achivement.errors = {};
            this.resetAchivementData();
            this.getAchivement();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.achivement.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save achivement =======================
    // ================= start part delete achivement =======================
    deleteAchivement(id) {
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
            axios
              .delete("/api/admin/achivement/delete/" + id)
              .then((result) => {
                if (result.data.status == true) {
                  Swal.fire("Deleted!", "تم حذف الانجاز", "success");
                  this.getAchivement();
                } else if (result.data.status == null) {
                  Toast.fire({
                    icon: "error",
                    title: result.data.error,
                  });
                } else {
                  this.achivement.errors = result.data.errors;
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
    // ================= end part delete achivement =======================
    // ================= start part get achivement with pagination =======================
    getAchivement(page = this.page) {
      axios
        .get(
          "/api/admin/achivement/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllAchivement = res.data.achivement;
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
    // ================= end part get achivement with pagination =======================
    // ================= start part active achivement =======================
    activeachivement(id) {
      axios
        .put("/api/admin/achivement/activation/" + id, this.achivement.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل الانجاز بنجاح"
                  : "تم الغاء تفعيل الانجاز بنجاح",
            });
            this.getAchivement();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },

    searchAchivement(e) {
      let search = e.target.value;
      this.search = search;
      this.getAchivement();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setAchivement_image(e) {
      this.achivement.data.achivement_image = e.target.files[0];
    },
    setAchivement_icon(e) {
      this.achivement.data.achivement_icon = e.target.files[0];
    },
  },
  created() {
    this.getAchivement();
  },
};
</script>

<style lang="scss" scoped>
.achivement {
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
