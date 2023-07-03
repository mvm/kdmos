/* Main mvcblog-front script */

//load external resources
function loadTextFile(url) {
  return new Promise((resolve, reject) => {
    $.get({
      url: url,
      cache: true,
      dataType: 'text'
    }).then((source) => {
      resolve(source);
    }).fail(() => reject());
  });
}


// Configuration
var AppConfig = {
  backendServer: 'http://localhost'
  //backendServer: '/mvcblog'
}

Handlebars.templates = {};
Promise.all([
    I18n.initializeCurrentLanguage('js/i18n'),
    loadTextFile('templates/components/main.hbs').then((source) =>
      Handlebars.templates.main = Handlebars.compile(source)),
    loadTextFile('templates/components/language.hbs').then((source) =>
      Handlebars.templates.language = Handlebars.compile(source)),
    loadTextFile('templates/components/user.hbs').then((source) =>
      Handlebars.templates.user = Handlebars.compile(source)),
    loadTextFile('templates/components/login.hbs').then((source) =>
      Handlebars.templates.login = Handlebars.compile(source)),
    loadTextFile('templates/components/survey-add.hbs').then((source) =>
      Handlebars.templates.surveyadd = Handlebars.compile(source)),
    loadTextFile('templates/components/survey-list.hbs').then((source) =>
      Handlebars.templates.surveylist = Handlebars.compile(source)),
    loadTextFile('templates/components/survey-row.hbs').then((source) =>
      Handlebars.templates.surveyrow = Handlebars.compile(source)),
    loadTextFile('templates/components/option.hbs').then((source) =>
      Handlebars.templates.option = Handlebars.compile(source)),
	loadTextFile('templates/components/votes.hbs').then((source) =>
      Handlebars.templates.votes = Handlebars.compile(source)),
	loadTextFile('templates/components/votes-add.hbs').then((source) =>
      Handlebars.templates.votesadd = Handlebars.compile(source)),
    loadTextFile('templates/components/posts-table.hbs').then((source) =>
      Handlebars.templates.poststable = Handlebars.compile(source)),      
    loadTextFile('templates/components/post-edit.hbs').then((source) =>
      Handlebars.templates.postedit = Handlebars.compile(source)),
    loadTextFile('templates/components/post-view.hbs').then((source) =>
      Handlebars.templates.postview = Handlebars.compile(source)),
    loadTextFile('templates/components/post-row.hbs').then((source) =>
      Handlebars.templates.postrow = Handlebars.compile(source))
  ])
  .then(() => {
      $(() => {
      new MainComponent().start();
    });
  }).catch((err) => {
    alert('FATAL: could not start app ' + err);
  });
