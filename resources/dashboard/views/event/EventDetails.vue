<template>
  <div class="events">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.preventDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الحدث
                    </h4>
                    <section class="content">
                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق صوره الحدث'
                          )
                        "
                        class="avatar-upload"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              accept=".png, .jpg, .jpeg"
                              @change="setImage"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            class="profile-event-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !event.data.image
                                ? '/images/test.png'
                                : !changeImage
                                ? `/images/event/${event.data.image}`
                                : getImageFile()
                            "
                            alt="event profile picture"
                          />
                          <span class="text-danger" v-if="event.errors.image">
                            {{ event.errors.image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
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
                        <span
                          v-if="event.errors.overview"
                          class="invalid-feedback"
                        >
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
                        <span
                          v-if="event.errors.active"
                          class="invalid-feedback"
                        >
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
                        <span
                          v-if="event.errors.active"
                          class="invalid-feedback"
                        >
                          {{ event.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateEvent"
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
  name: "eventDetails",
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
      changeImage: false,
      event: {
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
    // ================= start part get event  =======================
    getEvent() {
      axios
        .get("/api/admin/event/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.event.data = res.data.event;
            this.event.data.event_date = moment(
              this.event.data.event_date
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
    // ================= end part get event  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.event.errors = {};
      this.changeImage = true;
      this.event.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/event/upload/file/" + this.$route.params.id,
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
            this.event.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.event.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getEvent();
  },
};
</script>

<style lang="scss" scoped>
.profile-event-img {
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
