<template>
  <div class="aboutUs">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.praboutUsDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات صفحه عنا
                    </h4>

                    <div>
                      <!-- description -->
                      <div class="form-contole">
                        <label class="form-controle"> الوصف</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.description ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.description"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.description"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.description[0] }}
                        </span>
                      </div>
                      <!-- vision -->
                      <div class="form-contole">
                        <label class="form-controle"> الرؤيه</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.vision ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.vision"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.vision"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.vision[0] }}
                        </span>
                      </div>
                      <!-- message -->
                      <div class="form-contole">
                        <label class="form-controle"> الرساله</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.message ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.message"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.message"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.message[0] }}
                        </span>
                      </div>
                      <!-- strategic_one_title -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >العنوان للاستراتيجيه الاولي</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_one_title
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_one_title"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_one_title"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_one_title[0] }}
                        </span>
                      </div>
                      <!-- strategic_one_content -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >المحتوي للاستراتيجيه الاولي</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_one_content
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_one_content"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_one_content"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_one_content[0] }}
                        </span>
                      </div>
                      <!-- strategic_tow_title -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >العنوان للاستراتيجيه الثاني</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_tow_title
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_tow_title"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_tow_title"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_tow_title[0] }}
                        </span>
                      </div>
                      <!-- strategic_tow_content -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >المحتوي للاستراتيجيه الثاني</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_tow_content
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_tow_content"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_tow_content"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_tow_content[0] }}
                        </span>
                      </div>
                      <!-- strategic_three_title -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >العنوان للاستراتيجيه الثالث</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_three_title
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_three_title"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_three_title"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_three_title[0] }}
                        </span>
                      </div>
                      <!-- strategic_three_content -->
                      <div class="form-contole">
                        <label class="form-controle"
                          >المحتوي للاستراتيجيه الثالث</label
                        >
                        <ckeditor
                          :class="[
                            'form-control',
                            aboutUs.errors.strategic_three_content
                              ? 'is-invalid'
                              : '',
                          ]"
                          :editor="editor"
                          v-model="aboutUs.data.strategic_three_content"
                          :config="editorConfig"
                        ></ckeditor>

                        <span
                          v-if="aboutUs.errors.strategic_three_content"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.strategic_three_content[0] }}
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
                            aboutUs.errors.page_description ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="aboutUs.data.page_description"
                        ></textarea>
                        <span
                          v-if="aboutUs.errors.page_description"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.page_description[0] }}
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
                            aboutUs.errors.page_keywords ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="aboutUs.data.page_keywords"
                        ></textarea>
                        <span
                          v-if="aboutUs.errors.page_keywords"
                          class="invalid-feedback"
                        >
                          {{ aboutUs.errors.page_keywords[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      v-if="
                        this.$store.getters.getPermissionsData.includes(
                          'تعديل صفحه عنا'
                        )
                      "
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateAboutUs"
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
  name: "aboutUsDetails",
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
          ],
        },
      },
      aboutUs: {
        data: {
          id: 0,
          description: "",
          vision: "",
          message: "",
          strategic_one_title: "",
          strategic_one_content: "",
          strategic_tow_title: "",
          strategic_tow_content: "",
          strategic_three_title: "",
          strategic_three_content: "",
          page_keywords: "",
          page_description: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update aboutUs =======================
    updateAboutUs() {
      axios
        .put("/api/admin/about-us/update", this.aboutUs.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات صفحه عنا بنجاح",
            });
            this.aboutUs.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.aboutUs.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update aboutUs =======================
    // ================= start part get aboutUs  =======================
    getAboutUs() {
      axios
        .get("/api/admin/about-us/show")
        .then((res) => {
          if (res.data.status == true) {
            this.aboutUs.data = res.data.about_us;
            console.log(res.data.about_us);
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
    // ================= end part get aboutUs  =======================
  },
  created() {
    this.getAboutUs();
  },
};
</script>

<style lang="scss" scoped>
.profile-aboutUs-img {
  border-radius: 50%;
  width: 100%;
  height: 100%;
}

.avatar-upload {
  position: relative;
  width: 8.5%;
  aspect-ratio: 1/1;
  margin: auto;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 50%;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  padding: 2px;
  .avatar-preview {
    width: 100%;
    height: 100%;
  }
  .avatar-edit {
    position: absolute;
    right: 1px;
    z-index: 1;
    top: 90px;
    input {
      display: none;
      + label {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #ffffff;
        border: 1px solid #d2d6de;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        &:hover {
          background: #f1f1f1;
          border-color: #d6d6d6;
        }
      }
    }
  }
}
</style>
