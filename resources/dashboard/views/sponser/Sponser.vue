<template>
  <div class="sponser">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه داعم')
                "
                @click="createSponser"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه داعم
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه داعم')
                "
                href="/sponser/excel"
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
                @input="searchSponser"
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
                    <th class="border-bottom-0">المسمي</th>
                    <th class="border-bottom-0">اللينك</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(sponser, index) in AllSponsers.data" :key="index">
                    <td>{{ sponser.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              sponser.logo
                                ? '/images/sponsers/' + sponser.logo
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p>{{ sponser.title }}</p>
                      </div>
                    </td>

                    <td>
                      <p>
                        <a target="_blank" :href="sponser.company_url">{{
                          sponser.company_url
                        }}</a>
                      </p>
                    </td>
                    <td>
                      <span
                        v-if="sponser.active == '1'"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span
                        v-if="sponser.active == '0'"
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
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editSponser(sponser)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteSponser(sponser.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            class="modal-effect dropdown-item text-right"
                            @click="activeSponser(sponser.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              sponser.active == "1" ? "الغاء التفعيل" : "تفعيل"
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
                            :to="'/dashboard/sponser/' + sponser.id"
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
            :pages="AllSponsers.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getSponser"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.sponser.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">مسمي الداعم</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        sponser.errors.title ? 'is-invalid' : '',
                      ]"
                      v-model="sponser.data.title"
                    />

                    <span v-if="sponser.errors.title" class="invalid-feedback">
                      {{ sponser.errors.title[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">لينك الداعم</label>
                    <input
                      :class="[
                        'form-control',
                        sponser.errors.company_url ? 'is-invalid' : '',
                      ]"
                      v-model="sponser.data.company_url"
                    />
                    <span
                      v-if="sponser.errors.company_url"
                      class="invalid-feedback"
                    >
                      {{ sponser.errors.company_url[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!sponser.edit">
                    <label class="form-controle">صوره الداعم</label>
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
                      v-if="sponser.errors.logo"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ sponser.errors.logo[0] }}
                    </span>
                  </div>

                  <div v-show="sponser.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="sponser.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="sponser.errors.active" class="invalid-feedback">
                      {{ sponser.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!sponser.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="sponser.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="sponser.errors.active" class="invalid-feedback">
                      {{ sponser.errors.active[0] }}
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
                    v-if="sponser.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateSponser"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!sponser.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveSponser"
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
  name: "sponserPage",
  data: () => {
    return {
      search: "",
      AllSponsers: {},
      page: 1,
      sponser: {
        edit: false,
        data: {
          id: "",
          title: "",
          company_url: "",
          active: 1,
          logo: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit sponser =======================
    editSponser(sponser) {
      this.sponser.errors = {};
      this.sponser.data = sponser;
      this.sponser.edit = true;
    },
    // ================= end part edit sponser =======================
    // ================= start part update sponser =======================
    updateSponser() {
      axios
        .put(
          "/api/admin/sponser/update/" + this.sponser.data.id,
          this.sponser.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الداعم بنجاح",
            });
            this.sponser.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.sponser.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update sponser =======================
    // ================= start part create sponser =======================
    createSponser() {
      this.sponser.edit = false;
      this.resetSponserData();
    },
    // ================= end part create sponser =======================
    // ================= start reset sponser =======================
    resetSponserData() {
      this.sponser.data = {
        id: "",
        title: "",
        company_url: "",
        active: 1,
        logo: "",
      };
      this.sponser.errors = {};
    },
    // ================= end reset sponser =======================
    // ================= start part save sponser =======================
    saveSponser() {
      axios
        .post("/api/admin/sponser/store", this.sponser.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الداعم بنجاح",
            });
            this.resetSponserData();
            this.getSponser();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.sponser.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save sponser =======================
    // ================= start part delete sponser =======================
    deleteSponser(id) {
      Swal.fire({
        title: "هل انتا متاكد ؟!",
        text: "لن تتمكن من ارجاع البيانات مره اخري",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      })
        .then((result) => {
          if (result.isConfirmed) {
            axios.delete("/api/admin/sponser/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف الداعم", "success");
                this.getSponser();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.sponser.errors = result.data.errors;
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
    // ================= end part delete sponser =======================
    // ================= start part get sponser with pagination =======================
    getSponser(page = this.page) {
      axios
        .get(
          "/api/admin/sponser/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllSponsers = res.data.sponser;
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
    // ================= end part get sponser with pagination =======================
    // ================= start part active sponser =======================
    activeSponser(id) {
      axios
        .put("/api/admin/sponser/activation/" + id, this.sponser.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل الداعم بنجاح"
                  : "تم الغاء تفعيل الداعم بنجاح",
            });
            this.getSponser();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save sponser =======================

    searchSponser(e) {
      let search = e.target.value;
      this.search = search;
      this.getSponser();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.sponser.data.logo = e.target.files[0];
    },
  },
  created() {
    this.getSponser();
  },
};
</script>

<style lang="scss" scoped>
.sponser {
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
