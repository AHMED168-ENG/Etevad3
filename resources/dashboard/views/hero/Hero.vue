<template>
  <div class="hero">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-header pb-0">
            <div class="col-12">
              <button
                v-if="
                  this.$store.getters.getPermissionsData.includes('اضافه بطل')
                "
                @click="createHero"
                class="modal-effect btn d-block m-2 btn-sm btn-outline-primary btn-block"
                title="انشاء"
                href="#modaldemo9"
                data-effect="effect-scale"
                data-id=""
                data-section_name=""
                data-toggle="modal"
              >
                اضافه بطل
              </button>
              <a
                v-if="
                  this.$store.getters.getPermissionsData.includes(
                    'تحميل اكسل البطل'
                  )
                "
                href="/hero/excel"
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
                @input="searchHero"
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
                    <th class="border-bottom-0">الوصف</th>
                    <th class="border-bottom-0">الحاله</th>
                    <th class="border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(hero, index) in AllHeros.data" :key="index">
                    <td>{{ hero.id }}</td>
                    <td>
                      <div class="d-flex align-items-center clamp">
                        <div class="table-td-image">
                          <img
                            :src="
                              hero.image
                                ? '/images/heros/' + hero.image
                                : '/images/avatar.jpg'
                            "
                            alt=""
                          />
                        </div>
                        <p>{{ hero.name }}</p>
                      </div>
                    </td>

                    <td class="clamp">
                      <p v-html="hero.description"></p>
                    </td>
                    <td>
                      <span
                        v-if="hero.active == '1'"
                        class="label text-success"
                      >
                        active</span
                      >
                      <span v-if="hero.active == '0'" class="label text-danger">
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
                                'تعديل بطل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="تعديل"
                            href="#modaldemo9"
                            data-effect="effect-scale"
                            data-id=""
                            data-section_name=""
                            data-toggle="modal"
                            @click="editHero(hero)"
                          >
                            <i class="fas fa-pen text-success"></i>
                            تعديل
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حذف بطل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            title="حذف"
                            @click="deleteHero(hero.id)"
                          >
                            <i class="fas fa-trash text-danger"></i>
                            حذف
                          </button>

                          <button
                            v-if="
                              this.$store.getters.getPermissionsData.includes(
                                'حاله البطل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            @click="activeHero(hero.id)"
                          >
                            <i class="text-success fas fa-money-bill"></i
                            >&nbsp;&nbsp;
                            {{ hero.active == "1" ? "الغاء التفعيل" : "تفعيل" }}
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
                                'تفاصيل البطل'
                              )
                            "
                            class="modal-effect dropdown-item text-right"
                            :to="'/dashboard/hero/' + hero.id"
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
            :pages="AllHeros.last_page"
            :range-size="1"
            active-color="#DCEDFF"
            align="center"
            @update:modelValue="getHero"
          ></VPagination>
        </div>
        <div class="modal" id="modaldemo9">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <h6 class="modal-title">
                  {{ this.hero.edit ? "تعديل" : "انشاء " }}
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
                    <label class="form-controle">اسم البطل</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        hero.errors.name ? 'is-invalid' : '',
                      ]"
                      v-model="hero.data.name"
                    />

                    <span v-if="hero.errors.name" class="invalid-feedback">
                      {{ hero.errors.name[0] }}
                    </span>
                  </div>

                  <div class="form-contole">
                    <label class="form-controle">وصف البطل</label>
                    <ckeditor
                      :class="[
                        'form-control',
                        hero.errors.description ? 'is-invalid' : '',
                      ]"
                      :editor="editor"
                      v-model="hero.data.description"
                      :config="editorConfig"
                    ></ckeditor>
                    <span
                      v-if="hero.errors.description"
                      class="invalid-feedback"
                    >
                      {{ hero.errors.description[0] }}
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
                        hero.errors.page_description ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="hero.data.page_description"
                    ></textarea>
                    <span
                      v-if="hero.errors.page_description"
                      class="invalid-feedback"
                    >
                      {{ hero.errors.page_description[0] }}
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
                        hero.errors.page_keywords ? 'is-invalid' : '',
                      ]"
                      type="text"
                      v-model="hero.data.page_keywords"
                    ></textarea>
                    <span
                      v-if="hero.errors.page_keywords"
                      class="invalid-feedback"
                    >
                      {{ hero.errors.page_keywords[0] }}
                    </span>
                  </div>

                  <div class="form-contole" v-show="!hero.edit">
                    <label class="form-controle">صوره البطل</label>
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
                      v-if="hero.errors.image"
                      style="color: red; font-size: 0.875em"
                    >
                      {{ hero.errors.image[0] }}
                    </span>
                  </div>

                  <div v-show="hero.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="hero.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1">مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="hero.errors.active" class="invalid-feedback">
                      {{ hero.errors.active[0] }}
                    </span>
                  </div>

                  <div v-if="!hero.edit" class="form-contole">
                    <label class="form-label">الحاله </label>
                    <select
                      v-model="hero.data.active"
                      id="select-beast"
                      class="form-control nice-select custom-select"
                    >
                      <option value="1" selected>مفعل</option>
                      <option value="0">غير مفعل</option>
                    </select>
                    <span v-if="hero.errors.active" class="invalid-feedback">
                      {{ hero.errors.active[0] }}
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
                    v-if="hero.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="updateHero"
                  >
                    تعديل
                  </button>
                  <button
                    v-if="!hero.edit"
                    type="submit"
                    class="btn btn-danger"
                    @click="saveHero"
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
  name: "heroPage",
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
            // {
            //   model: "heading1",
            //   view: "h1",
            //   title: "Heading 1",
            //   class: "ck-heading_heading1",
            // },
            // {
            //   model: "heading2",
            //   view: "h2",
            //   title: "Heading 2",
            //   class: "ck-heading_heading2",
            // },
          ],
        },
      },
      search: "",
      AllHeros: {},
      page: 1,
      hero: {
        edit: false,
        data: {
          id: "",
          name: "",
          description: "",
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
    // ================= end part edit hero =======================
    editHero(hero) {
      this.hero.errors = {};
      this.hero.data = hero;
      this.hero.edit = true;
    },
    // ================= end part edit hero =======================
    // ================= start part update hero =======================
    updateHero() {
      axios
        .put("/api/admin/hero/update/" + this.hero.data.id, this.hero.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات البطل بنجاح",
            });
            this.hero.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.hero.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update hero =======================
    // ================= start part create hero =======================
    createHero() {
      this.hero.edit = false;
      this.resetHeroData();
    },
    // ================= end part create hero =======================
    // ================= start reset hero =======================
    resetHeroData() {
      this.hero.data = {
        name: "",
        id: "",
        description: "",
        active: 1,
        page_description: "",
        page_keywords: "",
        image: "",
      };
      this.hero.errors = {};
    },
    // ================= end reset hero =======================
    // ================= start part save hero =======================
    saveHero() {
      axios
        .post("/api/admin/hero/store", this.hero.data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم انشاء البطل بنجاح",
            });
            this.resetHeroData();
            this.getHero();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.hero.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part save hero =======================
    // ================= start part delete hero =======================
    deleteHero(id) {
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
            axios.delete("/api/admin/hero/delete/" + id).then((result) => {
              if (result.data.status == true) {
                Swal.fire("Deleted!", "تم حذف البطل", "success");
                this.getHero();
              } else if (result.data.status == null) {
                Toast.fire({
                  icon: "error",
                  title: result.data.error,
                });
              } else {
                this.hero.errors = result.data.errors;
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
    // ================= end part delete hero =======================
    // ================= start part get hero with pagination =======================
    getHero(page = this.page) {
      axios
        .get(
          "/api/admin/hero/index?" + "search=" + this.search + "&page=" + page
        )
        .then((res) => {
          if (res.data.status == true) {
            this.AllHeros = res.data.hero;
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
    // ================= end part get hero with pagination =======================
    // ================= start part active hero =======================
    activeHero(id) {
      axios
        .put("/api/admin/hero/activation/" + id, this.hero.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title:
                result.data.active == true
                  ? "تم تفعيل البطل بنجاح"
                  : "تم الغاء تفعيل البطل بنجاح",
            });
            this.getHero();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          }
        });
    },
    // ================= end part save hero =======================

    searchHero(e) {
      let search = e.target.value;
      this.search = search;
      this.getHero();
    },
    // about time and date
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    setImage(e) {
      this.hero.data.image = e.target.files[0];
    },
  },
  created() {
    this.getHero();
  },
};
</script>

<style lang="scss" scoped>
.hero {
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
