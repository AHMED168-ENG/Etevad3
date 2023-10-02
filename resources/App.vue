<template>
  <router-view />
</template>

<style lang="scss" scope>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
// Import Main styles for this application
@import "./dashboard/styles/style";
table td {
  p {
    margin-bottom: 0 !important;
  }
}
*:not(i) {
  font-family: "Cairo" !important;
}
.container-lg {
  max-width: 100% !important;
}
.table-td-image {
  width: 50px;
  height: 50px;
  margin-left: 5px;
  box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
  img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
  }
  overflow: hidden;
  border: 1px solid #ddd;
  padding: 2px;
  border-radius: 50%;
  ~ p {
    flex: 1;
  }
}
.Pagination {
  margin: 0 auto 10px;
}
div.dataTables_wrapper div.dataTables_filter {
  width: 100%;
  label {
    display: block;
    width: 100%;
    text-align: right;
    input {
      width: 100% !important;
      display: block !important;
      outline: none !important;
      margin: 3px 0 !important;
      border-radius: 5px !important;
    }
  }
}
table.dataTable thead th {
  text-align: right !important;
}

// start search box

form.form_search_box {
  outline: 0;
  width: 100%;
  margin-bottom: 20px !important;
  -webkit-box-shadow:
    0 1px 3px rgba(0, 0, 0, 0.12),
    0 1px 2px rgba(0, 0, 0, 0.24),
    -1px -2px 2px rgba(0, 0, 0, 0.24);
  box-shadow:
    0 1px 3px rgba(0, 0, 0, 0.12),
    0 1px 2px rgba(0, 0, 0, 0.24),
    -1px -2px 2px rgba(0, 0, 0, 0.24);
  -webkit-border-radius: 4px;
  border-radius: 4px;
  display: flex;
}

form.form_search_box > .textbox {
  outline: 0;
  height: 42px;
  width: 244px;
  line-height: 42px;
  padding: 0 16px;
  background-color: rgba(255, 255, 255, 0.8);
  color: #212121;
  border: 0;
  float: left;
  flex: 1;

  -webkit-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

form.form_search_box > .textbox:focus {
  outline: 0;
  background-color: #fff;
}

form.form_search_box > .button {
  outline: 0;
  background: none;
  background-color: rgba(38, 50, 56, 0.8);
  float: right;
  height: 42px;
  width: 42px;
  text-align: center;
  line-height: 42px;
  border: 0;
  color: #fff;
  font: normal normal normal 14px/1 FontAwesome;
  font-size: 16px;
  text-rendering: auto;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  -webkit-transition: background-color 0.4s ease;
  transition: background-color 0.4s ease;
  -webkit-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

form.form_search_box > .button:hover {
  background-color: rgba(0, 150, 136, 0.8);
}
// end search box
.table th,
.table td {
  vertical-align: middle !important;
  text-align: center;
}
.modal-dialog {
  max-width: 50% !important;
}
.invalid-feedback {
  display: block !important;
}
.avatar-img {
  height: 100%;
}
.table thead th,
.table thead td {
  font-size: 13px !important;
}

// image css
.contentOfImages {
  margin: 15px 0 !important;
  .profile-achivement-img {
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
}
nav {
  padding: 30px;
  a {
    text-decoration: none !important;
    font-weight: bold;
    color: #2c3e50;
  }
}
</style>
