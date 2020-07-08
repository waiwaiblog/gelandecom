const ERROR_EMPTY = '入力してください';
const ERROR_NAME = '１０文字以内で入力';
const ERROR_MAIL = '正しい形式で入力';
const ERROR_COMMENT = '４文字以上で入力';

$('.send').prop("disabled", true);

$('.username').keyup(function() {
let form_g = $(this).closest('.form_g');
if($(this).val().length === 0) {
  form_g.find('.help-block').text(ERROR_EMPTY);
  form_g.addClass('has-error').removeClass('has-success');
} else if($(this).val().length > 10) {
  form_g.find('.help-block').text(ERROR_NAME);
  form_g.addClass('has-error').removeClass('has-success');
} else {
  form_g.find('.help-block').text('');
  form_g.addClass('has-success').removeClass('has-error');
}
});

$('.usermail').keyup(function() {
let form_g = $(this).closest('.form_g');

if($(this).val().length === 0) {
  form_g.find('.help-block').text(ERROR_EMPTY);
  form_g.addClass('has-error').removeClass('has-success');
} else if ($(this).val().length > 50 || !$(this).val().match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i)) {
  form_g.find('.help-block').text(ERROR_MAIL);  
  form_g.addClass('has-error').removeClass('has-success');
} else {
  form_g.find('.help-block').text('');
  form_g.addClass('has-success').removeClass('has-error');
}
});

$('.userpass').keyup(function() {
let form_g = $(this).closest('.form_g');

if($(this).val().length === 0) {
  form_g.find('.help-block').text(ERROR_EMPTY);
  form_g.addClass('has-error').removeClass('has-success');
} else if ($(this).val().length < 4) {
  form_g.find('.help-block').text(ERROR_COMMENT);
  form_g.addClass('has-error').removeClass('has-success');
} else {
  form_g.find('.help-block').text('');
  form_g.addClass('has-success').removeClass('has-error');
}
});

$('input').change(function() {
  let form_g = $(this).closest('.form_g');
  if($('.has-success').length){
    $('.send').prop("disabled", false);
  } else {
    $('.send').prop("disabled", true);
  }
})