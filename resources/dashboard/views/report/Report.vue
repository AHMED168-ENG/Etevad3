<template>
  <div class="report">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه تقرير')
                "
                @click="createReport"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه تقرير
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه تقرير')
                "
                href="/report/excel"
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
                @input="searchReport"
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
                    <th class="border-bottom-0">تاريخ التقرير</th>
                    <th class="border-bottom-0">محتوي التقرير</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(report, index) in AllReport.data" :key="index">
                    <td>{{ report.id }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div style="margin-left: 30px; display: inline-block">
                          <a href="" v-if="report.pdf">{{ report.pdf }}</a>
                        </div>
                        <p>{{ report.title }}</p>
                      </div>
                    </td>
                    <td>
                      <p>
                        {{ formateDate(report.report_date).date }}
                      </p>
                    </td>
                    <td class="clamp">
                      <p v-html="report.overview"></p>
                    </td>
                    <td>
                      <span
                        v-if="report.active == 1"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span v-if="report.active == 0" class="label text-danger">
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
                            @click="editReport(report)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteReport(report.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            @click="activeReport(report.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              report.active == "1" ? "الغاء التفعيل" : "تفعيل"
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
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/report/' + report.id"
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
            :pages="AllReport.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getReport"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.report.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">عنوان التقرير</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        report.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="report.data.title"
                    />

                    <span v-if="report.errors.title" class="invalid-feedback">
                      {{ report.errors.title[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">تاريخ التقرير</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        report.errors.report_date ? 'is-invalid' : '',
                      ]"
                      type="date"
                      v-model="report.data.report_date"
                    />
                    <span
                      v-if="report.errors.report_date"
                      class="invalid-feedback"
                    >
                      {{ report.errors.report_date[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">محتوي التقرير</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        report.errors.overview ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="report.data.overview"
                      :config="editorConfig"
                    ></ckeditor>
                    <span
                      v-if="report.errors.overview"
                      class="invalid-feedback"
                    >
                      {{ report.errors.overview[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!report.edit">
                    <label class="form-controle">ملف التقرير</label>
                    <div class="input-group mb-3">
                      <input
                        type="file"
                        class="form-control"
                        id="inputGroupFile02"
                        @change="setPdf"
                      />
                      <label class="input-group-text" for="inputGroupFile02"
                        >Upload</label
                      >
                    </div>
                    <span
                      v-if="report.errors.pdf"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ report.errors.pdf[0] }}
                    </span>
                  </div>

                  <div v-show="report.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="report.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="report.errors.active" class="invalid-feedback">
                      {{ report.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!report.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="report.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="report.errors.active" class="invalid-feedback">
                      {{ report.errors.active[0] }}
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
                    v-if="report.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateReport"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!report.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveReport"
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
  name: "reportPage",
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
      AllReport: {},
      page: 1,
      report: {
        edit: false,
        data: {
          id: "",
          title: "",
          report_date: "",
          overview: "",
          active: 1,
          pdf: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit report =======================
    editReport(report) {
      report.report_date = moment(report.report_date).format("YYYY-MM-DD");
      this.report.errors = {};
      this.report.edit = true;
      this.report.data = report;
    },
    // ================= end part edit report =======================
    // ================= start part update report =======================
    updateReport() {
      axios
        .put(
          "/api/admin/report/update/" + this.report.data.id,
          this.report.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات التقرير بنجاح",
            });
            this.report.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.report.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update report =======================
    // ================= start part create report =======================
    createReport() {
      this.report.edit = false;
      this.resetReportData();
    },
    // ================= end part create report =======================
    // ================= start reset report =======================
    resetReportData() {
      this.report.data = {
        id: "",
        title: "",
        report_date: "",
        overview: "",
        active: 1,
        pdf: "",
      };
      this.report.errors = {};
    },
    // ================= end reset report =======================
    // ================= start part save report =======================
    saveReport() {
      axios
        .post("/api/admin/report/store", this.report.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء التقرير بنجاح",
            });
            this.resetReportData();
            this.getReport();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.report.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save report =======================
    // ================= start part delete report =======================
    deleteReport(id) {
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
            axios.delete("/api/admin/report/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف التقرير", "success");
                this.getReport();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.report.errors = result.data.errors;
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
    // ================= end part delete report =======================
    // ================= start part get report with pagination =======================
    getReport(page = this.page) {
      axios
        .get(
          "/api/admin/report/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllReport = res.data.reports;
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
    // ================= end part get report with pagination =======================
    // ================= start part active report =======================
    activeReport(id) {
      axios
        .put("/api/admin/report/activation/" + id, this.report.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل التقرير بنجاح"
                  : "تم الغاء تفعيل التقرير بنجاح",
            });
            this.getReport();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save report =======================

    searchReport(e) {
      let search = e.target.value;
      this.search = search;
      this.getReport();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setPdf(e) {
      this.report.data.pdf = e.target.files[0];
    },
  },
  created() {
    this.getReport();
  },
};
</script>

<style lang="scss" scoped>
.report {
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
