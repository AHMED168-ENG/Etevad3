<template>
  <div class="achivement">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prachivementDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الانجاز
                    </h4>
                    <section class="content contentOfImages d-flex">
                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق الايكون الانجاز'
                          )
                        "
                        class="avatar-upload mx-1"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="iconUpload"
                              @change="setAchivement_icon"
                            />
                            <label for="iconUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            title="achivement icon"
                            class="profile-achivement-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !achivement.data.achivement_icon
                                ? '/images/test.png'
                                : !changeAchivement_icon
                                ? `/images/achivement/icons/${achivement.data.achivement_icon}`
                                : getIconFile()
                            "
                            alt="achivement profile picture"
                          />
                          <span
                            class="text-danger"
                            v-if="achivement.errors.achivement_icon"
                          >
                            {{ achivement.errors.achivement_icon[0] }}</span
                          >
                        </div>
                      </div>

                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق صوره الانجاز'
                          )
                        "
                        class="avatar-upload mx-1"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              @change="setAchivement_image"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            title="achivement image"
                            class="profile-achivement-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !achivement.data.achivement_image
                                ? '/images/test.png'
                                : !changeAchivement_image
                                ? `/images/achivement/images/${achivement.data.achivement_image}`
                                : getImageFile()
                            "
                            alt="achivement profile picture"
                          />
                          <span
                            class="text-danger"
                            v-if="achivement.errors.achivement_image"
                          >
                            {{ achivement.errors.achivement_image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">عنوان الانجاز</label>
                        <textarea
                          :class="[
                            'form-control',
                            achivement.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="achivement.data.title"
                        ></textarea>
                        <span
                          v-if="achivement.errors.title"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.title[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">تاريخ الانجاز</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            achivement.errors.achivement_date
                              ? 'is-invalid'
                              : '',
                          ]"
                          type="date"
                          v-model="achivement.data.achivement_date"
                        />
                        <span
                          v-if="achivement.errors.achivement_date"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.achivement_date[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">محتوي الانجاز</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            achivement.errors.content ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="achivement.data.content"
                          :config="editorConfig"
                        ></ckeditor>
                        <span
                          v-if="achivement.errors.content"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.content[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">نوع الانجاز</label>
                        <input
                          data-date-format="DD MMMM YYYY"
                          type="text"
                          :class="[
                            'form-control',
                            achivement.errors.achivement_kind
                              ? 'is-invalid'
                              : '',
                          ]"
                          v-model="achivement.data.achivement_kind"
                        />
                        <span
                          v-if="achivement.errors.achivement_kind"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.achivement_kind[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">قسم الانجاز</label>
                        <select
                          v-model="achivement.data.achivement_category"
                          id="select-beast"
                          :class="[
                            'form-control',
                            'custom-select',
                            'nice-select',
                            achivement.errors.achivement_category
                              ? 'is-invalid'
                              : '',
                          ]"
                        >
                          <option
                            :selected="
                              achivement.errors.achivement_category == 1
                                ? true
                                : false
                            "
                            value="1"
                          >
                            الروبوت
                          </option>
                          <option
                            :selected="
                              achivement.errors.achivement_category == 2
                                ? true
                                : false
                            "
                            value="2"
                          >
                            الرياضات اللاسلكيه
                          </option>
                        </select>

                        <span
                          v-if="achivement.errors.achivement_category"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.achivement_category[0] }}
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
                            achivement.errors.page_description
                              ? 'is-invalid'
                              : '',
                          ]"
                          type="text"
                          v-model="achivement.data.page_description"
                        ></textarea>
                        <span
                          v-if="achivement.errors.page_description"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.page_description[0] }}
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
                            achivement.errors.page_keywords ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="achivement.data.page_keywords"
                        ></textarea>
                        <span
                          v-if="achivement.errors.page_keywords"
                          class="invalid-feedback"
                        >
                          {{ achivement.errors.page_keywords[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateAchivement"
                    >
                      <i class="la la-check-square-o"></i>
                      حفظ
                    </button>
                  </div>
                </form>
              </div>
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
  name: "achivementDetails",
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
      changeAchivement_image: false,
      changeAchivement_icon: false,
      achivement: {
        data: {
          id: "",
          title: "",
          achivement_date: "",
          content: "",
          achivement_kind: "",
          achivement_image: "",
          achivement_icon: "",
          achivement_category: "",
          active: 1,
          page_description: "",
          page_keywords: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update achivement =======================
    updateAchivement() {
      axios
        .put(
          "/api/admin/achivement/update/" + this.achivement.data.id,
          this.achivement.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الانجاز بنجاح",
            });
            this.achivement.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.achivement.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update achivement =======================
    // ================= start part get achivement  =======================
    getAchivement() {
      axios
        .get("/api/admin/achivement/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.achivement.data = res.data.achivement;
            this.achivement.data.achivement_date = moment(
              this.achivement.data.achivement_date
            ).format("YYYY-MM-DD");
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
    // ================= end part get achivement  =======================
    // ================= start part set achivement icon  =======================
    setAchivement_icon(e) {
      this.achivement.errors = {};
      this.changeAchivement_icon = true;
      this.achivement.data.achivement_icon = e.target.files[0];
      let formData = new FormData();
      formData.append("achivement_icon", e.target.files[0]);
      axios
        .post(
          "/api/admin/achivement/upload/icon/" + this.$route.params.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل صوره الايقون بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.achivement.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set achivement icon  =======================
    // ================= start part set achivement image  =======================
    setAchivement_image(e) {
      console.log("image");
      this.achivement.errors = {};
      this.changeAchivement_image = true;
      this.achivement.data.achivement_image = e.target.files[0];
      let formData = new FormData();
      formData.append("achivement_image", e.target.files[0]);
      axios
        .post(
          "/api/admin/achivement/upload/image/" + this.$route.params.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل صوره الانجاز بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.achivement.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set achivement image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.achivement.data.achivement_image);
    },
    getIconFile() {
      return window.URL.createObjectURL(this.achivement.data.achivement_icon);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getAchivement();
  },
};
</script>

<style lang="scss" scoped></style>
