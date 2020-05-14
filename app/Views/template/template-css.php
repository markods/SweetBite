<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<style>

/* ====== colours ====== */
:root {
  --content-color: #eaeaea;
  --p-color:    #666666;

  --primary-color:   #53cf8f;
  --secondary-color: #8affb1;
  --tertiary-color:  #bdffd2;
  
  --hover-color:  #4aba80;
  --border-color: #2a704c;
  --input-color:  #e0fce9;
}






/* ====== structure ====== */
html,
body {
  height: 100%;
}
p {
  text-align: justify;
}


#navbar-container {
  position: fixed;
  top: 0px;
  width: 100%;
  height: 50px;
  z-index: 1000;
  margin: 0px;
}
#navbar .logo {
  width: 40px;
  height: 40px;
}
#navbar input {
  width: 200px;
}
#login, #register {
    float: right;
}
#searchbar-container {
  margin-top: 50px;
}


#sidebar {
  position: fixed;
  margin-left: -350px;
  top: 50px;
  width: 350px;
  height: 100%;
  z-index: 1001;
}
#sidebar.active {
  margin-left: 0px;
}


#content {
  flex: 1 0 auto;
}



/* ====== style ====== */
body {
  font-family: sans-serif;
}
p {
  font-size: 1.1em;
  line-height: 1.7em;
  color: var(--p-color);
}
a,
a:hover,
a:focus {
  text-decoration: none;
  color: inherit;
}


#navbar-container {
  background-color: var(--primary-color);
}
#navbar > * {
  white-space: nowrap;
  padding: 9px;
  align-self: center;
}
#navbar .brand {
  padding: 5px;
}
#navbar .button {
  border-radius: unset;
}
#navbar .button.active,
#navbar .button:hover {
  background-color: var(--hover-color);
  border-bottom: 4px solid var(--border-color);
}
#navbar .btn-link {
  color: unset;
}
#navbar .dropdown-menu {
    background-color: var(--tertiary-color);
}
#navbar label {
  margin-bottom: 2px;
  font-size: 12px;
}
#searchbar-container {
  background: var(--secondary-color);
}
#searchbar
{
  padding-top:    15px;
  padding-bottom: 15px;
}
#navbar input,
#searchbar input {
    background: var(--input-color);
    border: 1px solid var(--border-color);
}
#search {
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
}


#sidebar {
  padding: 20px;
  background: var(--tertiary-color);
}

#content {
    padding-top: 15px;
    background-color: var(--content-color);
}






/* ====== animations ====== */
#sidebar {
  -webkit-transition: all 0.3s; /* Safari */
  -o-transition: all 0.3s; /* Opera */
  transition: all 0.3s; /* Firefox, Chrome, ... */
}






/* ====== utilities ====== */
.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently supported by Chrome, Opera and Firefox */
}

.spacer {
  flex-grow: 1;
}

</style>

