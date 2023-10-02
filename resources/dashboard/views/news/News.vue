<template>
  <div class="news">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه خبر')
                "
                @click="createNews"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه خبر
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه خبر')
                "
                href="/news/excel"
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
                @input="searchNews"
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
                    <th class="border-bottom-0">تاريخ الخبر</th>
                    <th class="border-bottom-0">محتوي الخبر</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(news, index) in AllNews.data" :key="index">
                    <td>{{ news.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              news.image
                                ? '/images/news/' + news.image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p>{{ news.title }}</p>
                      </div>
                    </td>
                    <td>
                      <p>
                        {{ formateDate(news.news_date).date }}
                      </p>
                    </td>
                    <td class="clamp">
                      <p v-html="news.full_description"></p>
                    </td>
                    <td>
                      <span v-if="news.active == 1" class="label text-success">
                        active</span
                      >
                      <span v-if="news.active == 0" class="label text-danger">
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
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editNews(news)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteNews(news.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            @click="activeNews(news.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{ news.active == "1" ? "الغاء التفعيل" : "تفعيل" }}
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
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/news/' + news.id"
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
            :pages="AllNews.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getNews"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.news.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">عنوان الخبر</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        news.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="news.data.title"
                    />

                    <span v-if="news.errors.title" class="invalid-feedback">
                      {{ news.errors.title[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">تاريخ الخبر</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        news.errors.news_date ? 'is-invalid' : '',
                      ]"
                      type="date"
                      v-model="news.data.news_date"
                    />
                    <span v-if="news.errors.news_date" class="invalid-feedback">
                      {{ news.errors.news_date[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">محتوي الخبر</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        news.errors.full_description ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="news.data.full_description"
                      :config="editorConfig"
                    ></ckeditor>
                    <span
                      v-if="news.errors.full_description"
                      class="invalid-feedback"
                    >
                      {{ news.errors.full_description[0] }}
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
                        news.errors.page_description ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="news.data.page_description"
                    ></textarea>
                    <span
                      v-if="news.errors.page_description"
                      class="invalid-feedback"
                    >
                      {{ news.errors.page_description[0] }}
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
                        news.errors.page_keywords ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="news.data.page_keywords"
                    ></textarea>
                    <span
                      v-if="news.errors.page_keywords"
                      class="invalid-feedback"
                    >
                      {{ news.errors.page_keywords[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!news.edit">
                    <label class="form-controle">صوره الخبر</label>
                    <div class="input-group mb-3">
                      <input
                        type="file"
                        class="form-control"
                        id="inputGroupFile02"
                        @change="setImage"
                      />
                      <label class="input-group-text" for="inputGroupFile02"
                        >Upload</label
                      >
                    </div>
                    <span
                      v-if="news.errors.image"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ news.errors.image[0] }}
                    </span>
                  </div>

                  <div v-show="news.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="news.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="news.errors.active" class="invalid-feedback">
                      {{ news.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!news.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="news.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="news.errors.active" class="invalid-feedback">
                      {{ news.errors.active[0] }}
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
                    v-if="news.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateNews"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!news.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveNews"
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
  name: "newsPage",
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
          ],
        },
      },
      search: "",
      AllNews: {},
      page: 1,
      news: {
        edit: false,
        data: {
          id: "",
          title: "",
          news_date: "",
          full_description: "",
          active: 1,
          page_description: "",
          page_keywords: "",
          image: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit news =======================
    editNews(news) {
      news.news_date = moment(news.news_date).format("YYYY-MM-DD");
      this.news.errors = {};
      this.news.edit = true;
      this.news.data = news;
    },
    // ================= end part edit news =======================
    // ================= start part update news =======================
    updateNews() {
      axios
        .put("/api/admin/news/update/" + this.news.data.id, this.news.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الخبر بنجاح",
            });
            this.news.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.news.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update news =======================
    // ================= start part create news =======================
    createNews() {
      this.news.edit = false;
      this.resetNewsData();
    },
    // ================= end part create news =======================
    // ================= start reset news =======================
    resetNewsData() {
      this.news.data = {
        title: "",
        id: "",
        news_date: "",
        full_description: "",
        active: 1,
        page_description: "",
        page_keywords: "",
        image: "",
      };
    },
    // ================= end reset news =======================
    // ================= start part save news =======================
    saveNews() {
      axios
        .post("/api/admin/news/store", this.news.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الخبر بنجاح",
            });
            this.news.errors = {};
            this.resetNewsData();
            this.getNews();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.news.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save news =======================
    // ================= start part delete news =======================
    deleteNews(id) {
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
            axios.delete("/api/admin/news/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف الخبر", "success");
                this.getNews();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.news.errors = result.data.errors;
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
    // ================= end part delete news =======================
    // ================= start part get news with pagination =======================
    getNews(page = this.page) {
      axios
        .get(
          "/api/admin/news/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllNews = res.data.news;
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
    // ================= end part get news with pagination =======================
    // ================= start part active news =======================
    activeNews(id) {
      axios
        .put("/api/admin/news/activation/" + id, this.news.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل الخبر بنجاح"
                  : "تم الغاء تفعيل الخبر بنجاح",
            });
            this.getNews();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save news =======================

    // dataTableSeting() {
    //     $("#newsTable").DataTable({
    //         responsive: true,
    //         bProcessing: true,
    //         sAutoWidth: false,
    //         bDestroy: true,
    //         ordering: false,
    //         sPaginationType: "bootstrap", // full_numbers
    //         "iDisplayStart ": 10,
    //         iDisplayLength: 10,
    //         bPaginate: false, //hide pagination
    //         bFilter: false, //hide Search bar
    //         bInfo: false, // hide showing entries

    //         language: {
    //             url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
    //         },

    //         order: [[1, "asc"]],
    //         fixedColumns: {
    //             left: 1,
    //             right: 1,
    //         },
    //         paging: false,
    //         scrollCollapse: true,
    //         scrollX: true,
    //         scrollY: 800,
    //         display: "stripe",
    //     });
    //     $(".dataTables_length").addClass("bs-select");
    // },
    searchNews(e) {
      let search = e.target.value;
      this.search = search;
      this.getNews();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.news.data.image = e.target.files[0];
    },
  },
  created() {
    this.getNews();
  },
};
</script>

<style lang="scss" scoped>
.news {
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
