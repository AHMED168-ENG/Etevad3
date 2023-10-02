<template>
  <div class="recording">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل التسجيلات'
                  )
                "
                href="/event-recordings/excel"
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
                @input="searchRecording"
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
                    <th class="border-bottom-0">العمر</th>
                    <th class="border-bottom-0">الموبيل</th>
                    <th class="border-bottom-0">التاريخ</th>
                    <th class="border-bottom-0">الحدث</th>
                    <th class="border-bottom-0">الرؤيه</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(recording, index) in AllRecordings.data"
                    :key="index"
                  >
                    <td>{{ recording.id }}</td>

                    <td>
                      {{ recording.name }}
                    </td>

                    <td>
                      {{ recording.email }}
                    </td>

                    <td>
                      {{ recording.age }}
                    </td>

                    <td>
                      {{ recording.mobile }}
                    </td>
                    <td>
                      {{ formateDate(recording.createdAt).date }}
                    </td>
                    <td>
                      <router-link
                        :to="'/dashboard/Events/' + recording.event.id"
                        >{{ recording.event.name }}</router-link
                      >
                    </td>

                    <td>
                      <span
                        v-if="recording.is_seen == 1"
                        class="badge badge-pill badge-success label"
                      >
                        seen</span
                      >
                      <span
                        v-if="recording.is_seen == 0"
                        class="badge badge-pill badge-danger label"
                      >
                        not seen</span
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
                                'حذف التسجيل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteRecording(recording.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'تغير حاله رؤيه التسجيل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="changeRecordingSeen(recording.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              recording.is_seen == 1 ? "الغاء الرؤيه" : "رؤيه"
                            }}
                          </button>
                          <router-link
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'رؤيه التسجيل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/event-recording/' + recording.id"
                            ><i class="text-success fas fa-eye"></i
                            >&nbsp;&nbsp;عرض البيانات</router-link
                          >

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
                                'تفاصيل التسجيل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/recording-us/' + recording.id"
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
            :pages="AllRecordings.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getRecording"
          ></VPagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "recordingPage",
  data: () => {
    return {
      page: 1,
      search: "",
      AllRecordings: {},
      recording: {
        data: {
          id: "",
          name: "",
          email: "",
          age: 0,
          phone: 0,
          is_seen: 0,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part delete recording =======================
    deleteRecording(id) {
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
              .delete("/api/admin/event-recordings/delete/" + id)
              .then((result) => {
                if (result.data.status == true) {
                  Swal.fire("Deleted!", "تم حذف التسجيل", "success");
                  this.getRecording();
                } else if (result.data.status == null) {
                  Toast.fire({
                    icon: "error",
                    title: result.data.error,
                  });
                } else {
                  this.recording.errors = result.data.errors;
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
    // ================= end part delete recording =======================
    // ================= start part get recording with pagination =======================
    getRecording(page = this.page) {
      axios
        .get(
          "/api/admin/event-recordings/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllRecordings = res.data.event_recordings;
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
    // ================= end part get recording with pagination =======================
    // ================= start part active recording =======================
    changeRecordingSeen(id) {
      axios
        .put("/api/admin/event-recordings/change-seening/" + id)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.is_seen == true
                  ? "تم تحويل التسجيل الي مرئي بنجاح"
                  : "تم تحويل التسجيل غير مرئي بنجاح",
            });
            this.getRecording();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save recording =======================

    searchRecording(e) {
      let search = e.target.value;
      this.search = search;
      this.getRecording();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
  },
  created() {
    this.getRecording();
  },
};
</script>

<style lang="scss" scoped>
.recording {
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
