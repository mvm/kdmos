class LoginComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	super(Handlebars.templates.login, userModel);
	this.userModel = userModel;
	this.userService = new UserService();
	this.router = router;


    this.addEventListener('click', '#registerbutton', () => {
      this.userService.register({
          name: $('#name').val(),
		  surname: $('#surname').val(),
		  email: $('#email').val(),
          pass: $('#pass').val()
        })
        .then(() => {
          alert(I18n.translate('User registered! Please login'));
          this.userModel.set((model) => {
            model.registerErrors = {};
            model.registerMode = false;
          });
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.userModel.set(() => {
              this.userModel.registerErrors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });
    });
  }
}
