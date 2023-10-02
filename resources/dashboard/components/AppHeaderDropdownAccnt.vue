<template>
  <CDropdown variant="nav-item" onclick.prevent="">
    <CDropdownToggle
      href="page.html"
      onclick="return false"
      placement="bottom-end"
      class="py-0"
      :caret="true"
    >
      <CAvatar
        :src="
          this.$store.getters.getAdminData.image
            ? './images/user/' + this.$store.getters.getAdminData.image
            : './images/avatar.jpg'
        "
        size="md"
      />
    </CDropdownToggle>
    <CDropdownMenu style="text-align: right" class="pt-0">
      <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
        {{ this.$store.getters.getAdminData.name }}
      </CDropdownHeader>
      <!-- <CDropdownItem>
                <CIcon icon="cil-bell" /> Updates
                <CBadge color="info" class="ms-auto">{{ itemsCount }}</CBadge>
            </CDropdownItem>
            <CDropdownItem>
                <CIcon icon="cil-envelope-open" /> Messages
                <CBadge color="success" class="ms-auto">{{
                    itemsCount
                }}</CBadge>
            </CDropdownItem> -->
      <!-- <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
                Settings
            </CDropdownHeader> -->
      <CDropdownItem
        v-on:click="this.$router.push({ path: '/dashboard/profile' })"
      >
        <CIcon icon="cil-user" />
        تعديل الملف الشخصي
      </CDropdownItem>
      <CDropdownItem
        v-on:click="this.$router.push({ path: '/dashboard/seting' })"
        ><CIcon icon="cil-settings" /> الاعدادات
      </CDropdownItem>
      <!-- <CDropdownItem>
                <CIcon icon="cil-dollar" /> Payments
                <CBadge color="secondary" class="ms-auto">{{
                    itemsCount
                }}</CBadge>
            </CDropdownItem>
            <CDropdownItem>
                <CIcon icon="cil-file" /> Projects
                <CBadge color="primary" class="ms-auto">{{
                    itemsCount
                }}</CBadge>
            </CDropdownItem> -->
      <CDropdownDivider />

      <CDropdownItem>
        <button
          style="padding: 0; font-size: 12px !important"
          class="dropdown-item"
          @click.prevent="logout"
        >
          <CIcon icon="cil-lock-locked" />
          تسجيل الخروج
        </button>
      </CDropdownItem>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
export default {
  name: "AppHeaderDropdownAccnt",
  setup() {
    return {
      itemsCount: 42,
    };
  },
  methods: {
    logout() {
      axios
        .post("/api/admin/auth/logout")
        .then((result) => {
          if (result.data.status == true) {
            this.$router.push({ name: "تسجيل الدخول" });
            this.$store.commit("logout");
            Toast.fire({
              icon: "success",
              title: "تم تسجيل الخروج بنجاح",
            });
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
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
  },
};
</script>

<style lang="scss" scoped>
.nav-item .dropdown-item {
  cursor: pointer;
}
</style>
