<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<style>

/* ====== colours ====== */
:root {
  --content-color: #fafafa;
  --p-color:    #666666;

  --primary-color:   #53cf8f;
  --secondary-color: #8affb1;
  --tertiary-color:  #bdffd2;
  
  --navbar-item-hover-color:        #4aba80;
  --navbar-item-hover-border-color: #2a704c;
}



/* ====== structure ====== */
html,
body {
  height: 100%;
}

p {
  text-align: justify;
}


#navbar {
  position: fixed;
  top: 0px;
  width: 100%;
  height: 50px;
  z-index: 1000;
  margin: 0px;
}

#navbar img {
  width: 40px;
  height: 40px;
}

#login    .dropdown-menu .form-group input,
#register .dropdown-menu .form-group input {
  width: 200px;
}


#searchbar {
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

#sidebar a {
  display: block;
}
#sidebar a[data-toggle="collapse"] {
  position: relative;
}


#content {
  flex: 1 0 auto;
}


#footer {
  flex-shrink: none;
  text-align: center;
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


#navbar {
  background-color: var(--primary-color);
}
#navbar-content > * {
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
  background-color: var(--navbar-item-hover-color);
  border-bottom: 4px solid var(--navbar-item-hover-border-color);
}
#navbar .btn-link {
  color: unset;
}

#login    .dropdown-menu .form-group label,
#register .dropdown-menu .form-group label {
  margin-bottom: 2px;
  font-size: 12px;
}


#sidebar {
  background: var(--primary-color);
}

#sidebar .sidebar-content {
  padding: 20px;
  background: var(--tertiary-color);
}

#searchbar {
    padding-top:    15px;
    padding-bottom: 15px;
    background: var(--secondary-color);
}



/* ====== animations ====== */
#sidebar,
#sidebar a,
#sidebar a:hover,
#sidebar a:focus {
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

