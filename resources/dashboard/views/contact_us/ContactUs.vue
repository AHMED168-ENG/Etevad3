<template>
  <div class="message">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل الرسائل'
                  )
                "
                href="/contact/excel"
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
                @input="searchMessage"
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
                    <th class="border-bottom-0">العنوان</th>
                    <th class="border-bottom-0">التاريخ</th>
                    <th class="border-bottom-0">الرؤيه</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(message, index) in AllMessages.data" :key="index">
                    <td>{{ message.id }}</td>

                    <td>
                      {{ message.name }}
                    </td>

                    <td>
                      {{ message.email }}
                    </td>

                    <td>
                      {{ message.age }}
                    </td>

                    <td>
                      {{ message.phone }}
                    </td>

                    <td>
                      {{ message.title }}
                    </td>
                    <td>
                      {{ formateDate(message.createdAt).date }}
                    </td>
                    <td>
                      <span
                        v-if="message.is_seen == 1"
                        class="badge badge-pill badge-success label "
                      >
                        seen</span
                      >
                      <span
                        v-if="message.is_seen == 0"
                        class="badge badge-pill badge-danger label "
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
                                'حذف الرساله'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteMessage(message.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'تغير رؤيه الرساله'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="changeMessageSeen(message.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{ message.is_seen == 1 ? "الغاء الرؤيه" : "رؤيه" }}
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
                                'تفاصيل الرساله'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/contact-us/' + message.id"
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
            :pages="AllMessages.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getMessage"
          ></VPagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "messagesPage",
  name: "messagePage",
  data: () => {
    return {
      page: 1,
      search: "",
      AllMessages: {},
      message: {
        data: {
          id: "",
          name: "",
          email: "",
          age: 0,
          phone: 0,
          title: "",
          message: "",
          is_seen: 0,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part delete message =======================
    deleteMessage(id) {
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
            axios.delete("/api/admin/contact/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف الرساله", "success");
                this.getMessage();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.message.errors = result.data.errors;
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
    // ================= end part delete message =======================
    // ================= start part get message with pagination =======================
    getMessage(page = this.page) {
      axios
        .get(
          "/api/admin/contact/index?" +
            "search=" +
            this.search +
            "&page=" +
            page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllMessages = res.data.messages;
            console.log(this.AllMessages);
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
    // ================= end part get message with pagination =======================
    // ================= start part active message =======================
    changeMessageSeen(id) {
      axios.put("/api/admin/contact/seening/" + id).then((result) => {
        if (result.data.status == true) {
          Toast.fire({
            icon: "success",
            title:
              result.data.is_seen == true
                ? "تم تحويل الرساله الي مرئي بنجاح"
                : "تم تحويل الرساله غير مرئي بنجاح",
          });
          this.getMessage();
        } else if (result.data.status == null) {
          Toast.fire({
            icon: "error",
            title: result.data.error,
          });
        }
      });
    },
    // ================= end part save message =======================

    searchMessage(e) {
      let search = e.target.value;
      this.search = search;
      this.getMessage();
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
    this.getMessage();
  },
};
</script>

<style lang="scss" scoped>
.message {
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
