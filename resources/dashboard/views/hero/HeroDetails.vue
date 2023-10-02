<template>
  <div class="hero">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prheroDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات البطل
                    </h4>
                    <section
                      class="content"
                      v-if="
                        this.$store.getters.getPermissionsData.includes(
                          'ارفاق صوره البطل'
                        )
                      "
                    >
                      <div class="avatar-upload">
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              
                              @change="setImage"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            class="profile-hero-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !hero.data.image
                                ? '/images/test.png'
                                : !changeImage
                                ? `/images/heros/${hero.data.image}`
                                : getImageFile()
                            "
                            alt="hero profile picture"
                          />
                          <span class="text-danger" v-if="hero.errors.image">
                            {{ hero.errors.image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
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

                      <div class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="hero.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="hero.errors.active"
                          class="invalid-feedback"
                        >
                          {{ hero.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      v-if="
                        this.$store.getters.getPermissionsData.includes(
                          'تعديل بطل'
                        )
                      "
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateHero"
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
  name: "heroDetails",
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
        // heading: {
        //   options: [
        //     {
        //       model: "paragraph",
        //       title: "Paragraph",
        //       class: "ck-heading_paragraph",
        //     },
        //     {
        //       model: "heading1",
        //       view: "h1",
        //       title: "Heading 1",
        //       class: "ck-heading_heading1",
        //     },
        //     {
        //       model: "heading2",
        //       view: "h2",
        //       title: "Heading 2",
        //       class: "ck-heading_heading2",
        //     },
        //   ],
        // },
      },
      changeImage: false,
      hero: {
        data: {
          id: "",
          name: "",
          description: "",
          active: 1,
          page_description: "",
          page_keywords: "",
          image: "",
        },
        errors: {},
      },
    };
  },
  methods: {
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
    // ================= start part get hero  =======================
    getHero() {
      axios
        .get("/api/admin/hero/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.hero.data = res.data.hero;
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
    // ================= end part get hero  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.hero.errors = {};
      this.changeImage = true;
      this.hero.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/hero/upload/file/" + this.$route.params.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل الصوره بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.hero.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.hero.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getHero();
  },
};
</script>

<style lang="scss" scoped>
.profile-hero-img {
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
