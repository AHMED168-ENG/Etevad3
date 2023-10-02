<template>
  <div class="coverages">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه تغطيه')
                "
                @click="createCoverages"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه تغطيه
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل التغطيه'
                  )
                "
                href="/coverage/excel"
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
                @input="searchCoverages"
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
                    <th class="border-bottom-0">الفيديو</th>
                    <th class="border-bottom-0">العنوان</th>
                    <th class="border-bottom-0">تاريخ التغطيه</th>

                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(coverage, index) in AllCoverages.data"
                    :key="index"
                  >
                    <td>{{ coverage.id }}</td>
                    <td>
                      <iframe
                        width="640"
                        height="520"
                        :src="
                          'https://www.youtube.com/embed/' + coverage.video_id
                        "
                      >
                      </iframe>
                    </td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <p v-html="coverage.title"></p>
                      </div>
                    </td>

                    <td>
                      {{ formateDate(coverage.coverage_date).date }}
                    </td>
                    <!-- <td >
                                          

                                        </td> -->

                    <td>
                      <span
                        v-if="coverage.active == 1"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span
                        v-if="coverage.active == 0"
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
                                'تعديل تغطيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editCoverages(coverage)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف تغطيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteCoverages(coverage.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله التغطيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeCoverages(coverage.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              coverage.active == "1" ? "الغاء التفعيل" : "تفعيل"
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
                                'تفاصيل التغطيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/coverage/' + coverage.id"
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
            :pages="AllCoverages.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getCoverages"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.coverage.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">عنوان التغطيه</label>
                    <textarea
                      :class="[
                        'form-control',
                        coverage.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="coverage.data.title"
                    ></textarea>
                    <span v-if="coverage.errors.title" class="invalid-feedback">
                      {{ coverage.errors.title[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">تاريخ التغطيه</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        coverage.errors.coverage_date ? 'is-invalid' : '',
                      ]"
                      type="date"
                      v-model="coverage.data.coverage_date"
                    />
                    <span
                      v-if="coverage.errors.coverage_date"
                      class="invalid-feedback"
                    >
                      {{ coverage.errors.coverage_date[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle"
                      >الفيديو الخاص بالتغطيه (id)</label
                    >
                    <textarea
                      autocomplete="on"
                      :class="[
                        'form-control',
                        coverage.errors.video_id ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="coverage.data.video_id"
                    ></textarea>
                    <span
                      v-if="coverage.errors.video_id"
                      class="invalid-feedback"
                    >
                      {{ coverage.errors.video_id[0] }}
                    </span>
                  </div>

                  <div v-show="coverage.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="coverage.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="coverage.errors.active"
                      class="invalid-feedback"
                    >
                      {{ coverage.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!coverage.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="coverage.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="coverage.errors.active"
                      class="invalid-feedback"
                    >
                      {{ coverage.errors.active[0] }}
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
                    v-if="coverage.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateCoverages"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!coverage.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveCoverages"
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
  name: "coveragesPage",
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
      page: 1,
      search: "",
      AllCoverages: {},
      coverage: {
        edit: false,
        data: {
          id: "",
          title: "",
          coverage_date: "",
          video_id: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit coverages =======================
    editCoverages(coverages) {
      coverages.coverage_date = moment(coverages.coverage_date).format(
        "YYYY-MM-DD"
      );
      this.coverage.edit = true;
      this.coverage.data = coverages;
      this.event.errors = {};
    },
    // ================= end part edit coverages =======================
    // ================= start part update coverages =======================
    updateCoverages() {
      axios
        .put(
          "/api/admin/coverage/update/" + this.coverage.data.id,
          this.coverage.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات التغطيه بنجاح",
            });
            this.coverage.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.coverage.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update coverages =======================
    // ================= start part create coverages =======================
    createCoverages() {
      this.coverage.edit = false;
      this.resetCoveragesData();
    },
    // ================= end part create coverages =======================
    // ================= start reset coverages =======================
    resetCoveragesData() {
      this.coverage.data = {
        id: "",
        title: "",
        coverage_date: "",
        video_id: "",
        active: 1,
      };
    },
    // ================= end reset coverages =======================
    // ================= start part save coverages =======================
    saveCoverages() {
      axios
        .post("/api/admin/coverage/store", this.coverage.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء التغطيه بنجاح",
            });
            this.coverage.errors = {};
            this.resetCoveragesData();
            this.getCoverages();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.coverage.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save coverages =======================
    // ================= start part delete coverages =======================
    deleteCoverages(id) {
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
            axios.delete("/api/admin/coverage/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف التغطيه", "success");
                this.getCoverages();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.coverage.errors = result.data.errors;
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
    // ================= end part delete coverages =======================
    // ================= start part get coverages with pagination =======================
    getCoverages(page = this.page) {
      axios
        .get(
          "/api/admin/coverage/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllCoverages = res.data.coverage;
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
    // ================= end part get coverages with pagination =======================
    // ================= start part active coverages =======================
    activeCoverages(id) {
      axios.put("/api/admin/coverage/activation/" + id).then((result) => {
        if (result.data.status == true) {
          Toast.fire({
            icon: "success",
            title:
              result.data.active == true
                ? "تم تفعيل التغطيه بنجاح"
                : "تم الغاء تفعيل التغطيه بنجاح",
          });
          this.getCoverages();
        } else if (result.data.status == null) {
          Toast.fire({
            icon: "error",
            title: result.data.error,
          });
        }
      });
    },
    // ================= end part save coverages =======================

    searchCoverages(e) {
      let search = e.target.value;
      this.search = search;
      this.getCoverages();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.coverage.data.image = e.target.files[0];
    },
  },
  created() {
    this.getCoverages();
  },
};
</script>

<style lang="scss" scoped>
.coverages {
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
td iframe {
  width: 300px;
  height: 100px;
}
</style>
