<template>
  <div class="statistic">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'اضافه احصائيه'
                  )
                "
                @click="createStatistic"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه احصاء
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل الاحصائيه'
                  )
                "
                href="/statistic/excel"
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
                @input="searchStatistic"
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
                    <th class="border-bottom-0">العدد</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(statistic, index) in AllStatistic.data"
                    :key="index"
                  >
                    <td>{{ statistic.id }}</td>

                    <td>
                      {{ statistic.statistic_name }}
                    </td>

                    <td>
                      {{ statistic.statistic_count }}
                    </td>
                    <!-- <td >
                                          

                                        </td> -->

                    <td>
                      <span
                        v-if="statistic.active == 1"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span
                        v-if="statistic.active == 0"
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
                                'تعديل احصائيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editStatistic(statistic)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف احصائيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteStatistic(statistic.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله الاحصائيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeStatistic(statistic.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              statistic.active == "1"
                                ? "الغاء التفعيل"
                                : "تفعيل"
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
                                'تفاصيل الاحصائيه'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/statistic/' + statistic.id"
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
            :pages="AllStatistic.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getStatistic"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.statistic.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">اسم الاحصاء</label>
                    <textarea
                      name=""
                      id=""
                      :class="[
                        'form-control',
                        statistic.errors.statistic_name ? 'is-invalid' : '',
                      ]"
                      v-model="statistic.data.statistic_name"
                    ></textarea>
                    <span
                      v-if="statistic.errors.statistic_name"
                      class="invalid-feedback"
                    >
                      {{ statistic.errors.statistic_name[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">عدد الاحصاء</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        statistic.errors.statistic_count ? 'is-invalid' : '',
                      ]"
                      type="number"
                      v-model="statistic.data.statistic_count"
                    />
                    <span
                      v-if="statistic.errors.statistic_count"
                      class="invalid-feedback"
                    >
                      {{ statistic.errors.statistic_count[0] }}
                    </span>
                  </div>

                  <div v-show="statistic.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="statistic.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="statistic.errors.active"
                      class="invalid-feedback"
                    >
                      {{ statistic.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!statistic.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="statistic.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="statistic.errors.active"
                      class="invalid-feedback"
                    >
                      {{ statistic.errors.active[0] }}
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
                    v-if="statistic.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateStatistic"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!statistic.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveStatistic"
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
  name: "statisticPage",
  data: () => {
    return {
      page: 1,
      search: "",
      AllStatistic: {},
      statistic: {
        edit: false,
        data: {
          id: "",
          statistic_name: "",
          statistic_count: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit statistic =======================
    editStatistic(statistic) {
      statistic.statistic_date = moment(statistic.statistic_date).format(
        "YYYY-MM-DD"
      );
      this.statistic.edit = true;
      this.statistic.data = statistic;
      this.statistic.errors = {};
    },
    // ================= end part edit statistic =======================
    // ================= start part update statistic =======================
    updateStatistic() {
      axios
        .put(
          "/api/admin/statistic/update/" + this.statistic.data.id,
          this.statistic.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الاحصاء بنجاح",
            });
            this.statistic.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.statistic.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update statistic =======================
    // ================= start part create statistic =======================
    createStatistic() {
      this.statistic.edit = false;
      this.resetStatisticData();
    },
    // ================= end part create statistic =======================
    // ================= start reset statistic =======================
    resetStatisticData() {
      this.statistic.data = {
        id: "",
        statistic_name: "",
        statistic_count: "",
        active: 1,
      };
    },
    // ================= end reset statistic =======================
    // ================= start part save statistic =======================
    saveStatistic() {
      axios
        .post("/api/admin/statistic/store", this.statistic.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الاحصاء بنجاح",
            });
            this.statistic.errors = {};
            this.resetStatisticData();
            this.getStatistic();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.statistic.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save statistic =======================
    // ================= start part delete statistic =======================
    deleteStatistic(id) {
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
            axios.delete("/api/admin/statistic/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف الاحصاء", "success");
                this.getStatistic();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.statistic.errors = result.data.errors;
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
    // ================= end part delete statistic =======================
    // ================= start part get statistic with pagination =======================
    getStatistic(page = this.page) {
      axios
        .get(
          "/api/admin/statistic/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllStatistic = res.data.statistic;
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
    // ================= end part get statistic with pagination =======================
    // ================= start part active statistic =======================
    activeStatistic(id) {
      axios.put("/api/admin/statistic/activation/" + id).then((result) => {
        if (result.data.status == true) {
          Toast.fire({
            icon: "success",
            title:
              result.data.active == true
                ? "تم تفعيل الاحصاء بنجاح"
                : "تم الغاء تفعيل الاحصاء بنجاح",
          });
          this.getStatistic();
        } else if (result.data.status == null) {
          Toast.fire({
            icon: "error",
            title: result.data.error,
          });
        }
      });
    },
    // ================= end part save statistic =======================

    searchStatistic(e) {
      let search = e.target.value;
      this.search = search;
      this.getStatistic();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.statistic.data.image = e.target.files[0];
    },
  },
  created() {
    this.getStatistic();
  },
};
</script>

<style lang="scss" scoped>
.statistic {
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
