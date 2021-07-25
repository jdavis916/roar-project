(function ( $ ) {

	window.InlineShortcodeView_bdp_post_carousel = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_carousel.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_carousel();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post_slider = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_slider();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post_gridbox_slider = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_gridbox_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_gridbox_slider();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_ticker = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_ticker.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_ticker();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_masonry = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_masonry.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_masonry();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_cat_slider = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_cat_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_cat_slider();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post_list = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_list.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_timeline = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_timeline.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post_gridbox = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_gridbox.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_tooltip();
			});
			return this;
		}
	});

	window.InlineShortcodeView_bdp_post_ctv1 = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_bdp_post_ctv1.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_tooltip();
			});
			return this;
		}
	});
	
	window.InlineShortcodeView_vc_column_text = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_vc_column_text.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_carousel();
				this.bdpp_init_post_slider();
				this.bdpp_init_post_gridbox_slider();
				this.bdpp_init_post_ticker();
				this.bdpp_init_post_masonry();
				this.bdpp_init_cat_slider();
				this.bdpp_tooltip();
			});
			return this;
		}
	});
	
	window.InlineShortcodeView_vc_raw_html = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_vc_raw_html.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function() {
				this.bdpp_init_post_carousel();
				this.bdpp_init_post_slider();
				this.bdpp_init_post_gridbox_slider();
				this.bdpp_init_post_ticker();
				this.bdpp_init_post_masonry();
				this.bdpp_init_cat_slider();
				this.bdpp_tooltip();
			});
			return this;
		}
	});

})( window.jQuery );