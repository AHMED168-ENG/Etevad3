<template>
  <div class="events">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه حدث')
                "
                @click="createEvent"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه حدث
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل الحدث'
                  )
                "
                href="/event/excel"
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
                @input="searchEvent"
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
                    <th class="border-bottom-0">تاريخ الحدث</th>
                    <th class="border-bottom-0">لمحه عن الحدث</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(event, index) in events.data" :key="index">
                    <td>{{ event.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              event.image
                                ? '/images/event/' + event.image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p>{{ event.name }}</p>
                      </div>
                    </td>
                    <td>
                      <p>
                        {{ formateDate(event.event_date).date }}
                      </p>
                    </td>
                    <td class="clamp">
                      <p v-html="event.overview"></p>
                    </td>
                    <td>
                      <span v-if="event.active == 1" class="label text-success">
                        active</span
                      >
                      <span v-if="event.active == 0" class="label text-danger">
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
                                'تعديل حدث'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editEvent(event)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف حدث'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteEvent(event.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله الحدث'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeEvent(event.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{
                              event.active == "1" ? "الغاء التفعيل" : "تفعيل"
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
                                'تفاصيل الحدث'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/Events/' + event.id"
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
            :pages="events.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getEvents"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.event.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">اسم الحدث</label>

                    <input
                      type="text"
                      :class="[
                        'form-control',
                        event.errors.name ? 'is-invalid' : '',
                      ]"
                      v-model="event.data.name"
                    />

                    <span v-if="event.errors.name" class="invalid-feedback">
                      {{ event.errors.name[0] }}
                    </span>
                  </div>
                  <div class="form-contole">
                    <label class="form-controle">تاريخ الحدث</label>
                    <input
                      autocomplete="on"
                      :class="[
                        'form-control',
                        event.errors.event_date ? 'is-invalid' : '',
                      ]"
                      type="date"
                      v-model="event.data.event_date"
                    />
                    <span
                      v-if="event.errors.event_date"
                      class="invalid-feedback"
                    >
                      {{ event.errors.event_date[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">لمحه عن الحدث</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        event.errors.overview ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="event.data.overview"
                      :config="editorConfig"
                    ></ckeditor>
                    <span v-if="event.errors.overview" class="invalid-feedback">
                      {{ event.errors.overview[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">وصف تفصيلي عن الحدث</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        event.errors.full_description ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="event.data.full_description"
                      :config="editorConfig"
                    ></ckeditor>
                    <span
                      v-if="event.errors.full_description"
                      class="invalid-feedback"
                    >
                      {{ event.errors.full_description[0] }}
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
                        event.errors.page_description ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="event.data.page_description"
                    ></textarea>
                    <span
                      v-if="event.errors.page_description"
                      class="invalid-feedback"
                    >
                      {{ event.errors.page_description[0] }}
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
                        event.errors.page_keywords ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="event.data.page_keywords"
                    ></textarea>
                    <span
                      v-if="event.errors.page_keywords"
                      class="invalid-feedback"
                    >
                      {{ event.errors.page_keywords[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!event.edit">
                    <label class="form-controle">صوره الحدث</label>
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
                      v-if="event.errors.image"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ event.errors.image[0] }}
                    </span>
                  </div>

                  <div v-show="event.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="event.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="event.errors.active" class="invalid-feedback">
                      {{ event.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!event.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="event.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="event.errors.active" class="invalid-feedback">
                      {{ event.errors.active[0] }}
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
                    v-if="event.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateEvent"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!event.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveEvent"
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
  name: "eventPage",
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
      events: {},
      event: {
        edit: false,
        data: {
          id: "",
          name: "",
          event_date: "",
          overview: "",
          active: 1,
          full_description: "",
          page_description: "",
          page_keywords: "",
          image: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= end part edit event =======================
    editEvent(event) {
      event.event_date = moment(event.event_date).format("YYYY-MM-DD");
      this.event.edit = true;
      this.event.data = event;
      this.event.errors = {};
    },
    // ================= end part edit event =======================
    // ================= start part update event =======================
    updateEvent() {
      axios
        .put("/api/admin/event/update/" + this.event.data.id, this.event.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الحدث بنجاح",
            });
            this.event.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.event.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update event =======================
    // ================= start part create event =======================
    createEvent() {
      this.event.edit = false;
      this.resetEventData();
    },
    // ================= end part create event =======================
    // ================= start reset event =======================
    resetEventData() {
      this.event.data = {
        name: "",
        event_date: "",
        overview: "",
        active: 1,
        full_description: "",
        page_description: "",
        page_keywords: "",
        image: "",
      };
    },
    // ================= end reset event =======================
    // ================= start part save event =======================
    saveEvent() {
      axios
        .post("/api/admin/event/store", this.event.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء الحدث بنجاح",
            });
            this.event.errors = {};
            this.resetEventData();
            this.getEvents();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.event.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save event =======================
    // ================= start part delete event =======================
    deleteEvent(id) {
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
            axios.delete("/api/admin/event/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف الحدث", "success");
                this.getEvents();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.event.errors = result.data.errors;
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
    // ================= end part delete event =======================
    // ================= start part get Events with pagination =======================
    getEvents(page = this.page) {
      axios
        .get(
          "/api/admin/event/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.events = res.data.events;
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
    // ================= end part get Events with pagination =======================
    // ================= start part active event =======================
    activeEvent(id) {
      axios
        .put("/api/admin/event/activation/" + id, this.event.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل الحدث بنجاح"
                  : "تم الغاء تفعيل الحدث بنجاح",
            });
            this.getEvents();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save event =======================

    // dataTableSeting() {
    //     $("#eventTable").DataTable({
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
    searchEvent(e) {
      let search = e.target.value;
      this.search = search;
      this.getEvents();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.event.data.image = e.target.files[0];
    },
  },
  created() {
    this.getEvents();
  },
};
</script>

<style lang="scss" scoped>
.events {
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
