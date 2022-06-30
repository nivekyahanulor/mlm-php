"use strict";

$("#toastr-1").click(function () {
  iziToast.info({
    title: 'Hello, world!',
    message: 'This awesome plugin is made iziToast toastr',
    position: 'topRight'
  });
});

$("#toastr-2").click(function () {
  iziToast.success({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'topRight'
  });
});

$("#toastr-3").click(function () {
  iziToast.warning({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'topRight'
  });
});

$("#toastr-4").click(function () {
  iziToast.error({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'topRight'
  });
});

$("#toastr-5").click(function () {
  iziToast.show({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'bottomRight'
  });
});

$("#toastr-6").click(function () {
  iziToast.show({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'bottomCenter'
  });
});

$("#toastr-7").click(function () {
  iziToast.show({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'bottomLeft'
  });
});

$("#toastr-8").click(function () {
  iziToast.show({
    title: 'Hello, world!',
    message: 'This awesome plugin is made by iziToast',
    position: 'topCenter'
  });
});

$("#toastr-login").click(function () {
  iziToast.show({
	id: "customerlogin", 
    title: 'Requesting Login',
    message: 'Processing Login ..',
    position: 'topCenter'
  });
});

$("#success-login").click(function () {
  iziToast.success({
    title: 'Hello! Welcome Back!',
    message: ' ',
    position: 'topCenter'
  });
});
$("#error-login").click(function () {
  iziToast.warning({
    title: 'Login Error! Please Try Again!',
    message: '',
    position: 'topCenter'
  });
});
$("#cart-remove").click(function () {
  iziToast.warning({
    title: 'Removing Cart Item',
    message: 'Please wait ..',
    position: 'topRight'
  });
});
