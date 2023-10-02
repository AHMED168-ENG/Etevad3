<template>
  <div class="director">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه مدير')
                "
                @click="createDirector"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه مدير
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل المدير'
                  )
                "
                href="/director/excel"
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
                @input="searchDirector"
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
                    <th class="border-bottom-0">الوضيفه</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(director, index) in AllDirectors.data"
                    :key="index"
                  >
                    <td>{{ director.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              director.image
                                ? '/images/directors/' + director.image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p>{{ director.title + " " + director.name }}</p>
                      </div>
                    </td>
                    <td>
                      {{ director.jop }}
                    </td>
                    <td>
                      <span
                        v-if="director.active == 1"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span
                        v-if="director.active == 0"
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
                                'تعديل مدير'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editDirector(director)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف مدير'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteDirector(director.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله المدير'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeDirector(director.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              director.active == 1 ? "الغاء التفعيل" : "تفعيل"
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
                                'تفاصيل المدير'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/director-details/' + director.id"
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
            :pages="AllDirectors.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getDirector"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.director.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle"> اسم المدير</label>
                    <input
                      :class="[
                        'form-control',
                        director.errors.name ? 'is-invalid' : '',
                      ]"
                      v-model="director.data.name"
                    />
                    <span v-if="director.errors.name" class="invalid-feedback">
                      {{ director.errors.name[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle"> لقب المدير</label>
                    <input
                      :class="[
                        'form-control',
                        director.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="director.data.title"
                    />
                    <span v-if="director.errors.title" class="invalid-feedback">
                      {{ director.errors.title[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle"> وظيفه المدير</label>
                    <input
                      :class="[
                        'form-control',
                        director.errors.jop ? 'is-invalid' : '',
                      ]"
                      v-model="director.data.jop"
                    />
                    <span v-if="director.errors.jop" class="invalid-feedback">
                      {{ director.errors.jop[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!director.edit">
                    <label class="form-controle">صوره المدير</label>
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
                      v-if="director.errors.image"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ director.errors.image[0] }}
                    </span>
                  </div>

                  <div v-show="director.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="director.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="director.errors.active"
                      class="invalid-feedback"
                    >
                      {{ director.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!director.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="director.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span
                      v-if="director.errors.active"
                      class="invalid-feedback"
                    >
                      {{ director.errors.active[0] }}
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
                    v-if="director.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateDirector"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!director.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveDirector"
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
export default {
  name: "directorPage",
  data: () => {
    return {
      page: 1,
      search: "",
      AllDirectors: {},
      director: {
        edit: false,
        data: {
          id: "",
          title: "",
          name: "",
          jop: "",
          image: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit director =======================
    editDirector(director) {
      this.director.edit = true;
      this.director.data = director;
      this.event.errors = {};
    },
    // ================= end part edit director =======================
    // ================= start part update director =======================
    updateDirector() {
      axios
        .put(
          "/api/admin/director/update/" + this.director.data.id,
          this.director.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات المدير بنجاح",
            });
            this.director.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.director.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update director =======================
    // ================= start part create director =======================
    createDirector() {
      this.director.edit = false;
      this.resetDirectorData();
    },
    // ================= end part create director =======================
    // ================= start reset director =======================
    resetDirectorData() {
      this.director.data = {
        id: "",
        title: "",
        name: "",
        jop: "",
        image: "",
        active: 1,
      };
    },
    // ================= end reset director =======================
    // ================= start part save director =======================
    saveDirector() {
      axios
        .post("/api/admin/director/store", this.director.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء المدير بنجاح",
            });
            this.director.errors = {};
            this.resetDirectorData();
            this.getDirector();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.director.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save director =======================
    // ================= start part delete director =======================
    deleteDirector(id) {
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
            axios.delete("/api/admin/director/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف المدير", "success");
                this.getDirector();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.director.errors = result.data.errors;
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
    // ================= end part delete director =======================
    // ================= start part get director with pagination =======================
    getDirector(page = this.page) {
      axios
        .get(
          "/api/admin/director/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllDirectors = res.data.directors;
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
    // ================= end part get director with pagination =======================
    // ================= start part active director =======================
    activeDirector(id) {
      axios
        .put("/api/admin/director/activation/" + id, this.director.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل المدير بنجاح"
                  : "تم الغاء تفعيل المدير بنجاح",
            });
            this.getDirector();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },

    searchDirector(e) {
      let search = e.target.value;
      this.search = search;
      this.getDirector();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.director.data.image = e.target.files[0];
    },
    setDirectorImage(e) {
      this.director.data.image = e.target.files[0];
    },
  },
  created() {
    this.getDirector();
  },
};
</script>

<style lang="scss" scoped>
.director {
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
