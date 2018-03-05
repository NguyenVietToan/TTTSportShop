
<div class="header-top">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="sub-menu">
					<ul class="nav nav-pills">
						<li>
							<form name="lang_form">
								{{ csrf_field() }}
								<select name="lang" class="form-control lang" id="">
									@foreach(Config::get('lang.list_lang') as $lang => $lang_display)
									<option value="{{ $lang }}"
										@if(session('lang') && session('lang') == $lang)
											selected
										@endif
									>{{ $lang_display }}</option>
									@endforeach
								</select>
							</form>
						</li>
					</ul>
				</div>
				<!-- /.sub-menu -->
			</div>

			<div class="col-sm-6">
				<div class="account pull-right">
					<ul class="nav nav-pills">
					@if (Auth::check())
						<li class="dropdown">
	                        <a href="" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <b class="caret"></b></a>
							<ul class="profile dropdown-menu">
								<li>
									<a href="{{ url('/tai-khoan') }}">
										<i class="fa fa-user" aria-hidden="true"></i>
										{{ (session('lang'))?Config::get('lang.'.session('lang'))['account_management']:Config::get('lang.vi')['account_management'] }}
									</a>
								</li>

								<li>
									<a href="{{ route('Logout') }}">
										<i class="fa fa-sign-in" aria-hidden="true"></i>
										{{ (session('lang')) ? Config::get('lang.'.session('lang'))['logout'] : Config::get('lang.vi')['logout'] }}
									</a>
								</li>
							</ul>
					@else
						<li>
							<a href="{{ route('getLogin') }}">
								<i class="fa fa-sign-in" aria-hidden="true"></i>
								{{ (session('lang')) ? Config::get('lang.'.session('lang'))['login'] : Config::get('lang.vi')['login'] }}
							</a>
						</li>
						<li>
							<a href="{{ route('getRegister') }}">
								<i class="fa fa-user" aria-hidden="true"></i>
								{{ (session('lang')) ? Config::get('lang.'.session('lang'))['register'] : Config::get('lang.vi')['register'] }}
							</a>
						</li>
					@endif
					</ul>
				</div>
				<!-- /.account -->
			</div>
		</div>
	</div>
</div>
<!-- /.header-top -->


<div class="header-middle">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="logo pull-left">
					<a href="{{ URL('/') }}"><img src="{{ asset('public/user/images/logo2.png') }}" alt="" height="60"></a>
				</div>
				<!-- /.logo -->
			</div>

			<div class="col-sm-8 col-xs-12">
				<div class="sub-menu shopping-cart pull-right">
					<ul class="nav nav-pills">
						<li><a href="{{ route('getContact') }}"><i class="fa fa-phone" aria-hidden="true"></i>{{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</a></li>
						<li>
							<a href="{{ route('getWishList') }}"><i class="fa fa-heart" aria-hidden="true"></i>{{ (session('lang'))?Config::get('lang.'.session('lang'))['favorite']:Config::get('lang.vi')['favorite'] }} <span>
									@if (Auth::check())
										(<span class='total_user_like_number'>{{ App\WishList::where(['user_id' => Auth::user()->id, 'is_liked' => 1])->count() }}</span>)
									@endif
								</span>
							</a>
						</li>
						<li><a href="{{ route('getDeliveryAddress') }}"><i class="fa fa-money" aria-hidden="true"></i>{{ (session('lang'))?Config::get('lang.'.session('lang'))['checkout']:Config::get('lang.vi')['checkout'] }}</a></li>
	                    <li class="dropdown hover">
	                    	<a href="{{ route('getCartInfo') }}" class="dropdown-toggle" id="shopping-cart"><span class="glyphicon glyphicon-shopping-cart" style="margin-right: 8px;"></span>{{ (session('lang'))?Config::get('lang.'.session('lang'))['cart']:Config::get('lang.vi')['cart'] }} (<span class='cart-count'>{{ Cart::count() }}</span>) <b class="caret"></b></a>
	                        <ul class="dropdown-menu">
	                            <li>
	                                <table>
	                                    <tbody>
	                                    	@foreach (Cart::content() as $item)
	                                    		<tr>
		                                            <td class="image">
		                                            	<a href=""><img width="50" height="50" src="{{ asset('resources/upload/images/product/thumbnail/'.$item->id.'/'.$item->options->image) }}" alt="abc" title=""></a>
		                                            </td>
		                                            <td class="tprice">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
		                                            <td class="quantity"><span style="font-size: 10px;">x</span>{{ $item->qty }}</td>
		                                            <td class="tdelete">
									                	<a href="{{ route('getDeleteItem', $item->rowId) }}" class="delete-item"><i class="fa fa-trash-o"></i></a>
									                </td>
		                                        </tr>
	                                    	@endforeach
	                                    </tbody>
	                                </table>
	                                <table class="tbtotal">
	                                    <tbody>
	                                        <tr>
	                                            <td class="text-center"><b>{{ (session('lang'))?Config::get('lang.'.session('lang'))['total_money']:Config::get('lang.vi')['total_money'] }}:</b></td>
	                                            <td class="text-center"><b>{{ Cart::subtotal(0,'','.') }} VNĐ</b></td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                                <div class="button-wrap">
	                                	<a class="btn btn-primary checkout" href="{{ route('getDeliveryAddress') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['checkout']:Config::get('lang.vi')['checkout'] }}</a>
	                                	<a class="btn btn-primary viewcart" href="{{ route('getCartInfo') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['view_cart']:Config::get('lang.vi')['view_cart'] }}</a>
	                                </div>
	                            </li>
	                        </ul>
	                    </li>
	                </ul>
				</div>
				<!-- /.shopping-cart -->
			</div>
		</div>
	</div>
</div>
<!-- /.header-middle -->

<div class="header-bottom navbar navbar-default navbar-static-top">
		<div class="row" style="margin: 0">
			<div class="my-menu pull-left">
				<div class="navbar-header">
		            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="mainmenu" >
		            <nav class="navbar-collapse collapse">
			            <ul class="nav navbar-nav">
						    <li><a href="{{ url('/') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></li>
						    <li><a href="{{ url('san-pham') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['product']:Config::get('lang.vi')['product'] }}</a></li>
		                    <li class="dropdown menu-large">
		                        <a href="" class="dropdown-toggle" data-toggle="dropdown">{{ (session('lang'))?Config::get('lang.'.session('lang'))['sport']:Config::get('lang.vi')['sport'] }}<b class="caret"></b></a>
								<ul class="dropdown-menu mega-menu">
									<div class="row">
										<?php
											$sports = DB::table('sports')->whereBetween('id', [1,4])->get();
											$cates  = DB::table('categories')->orderBy('id', 'asc')->get();
										?>
										@foreach ($sports as $sport)
										<div class="col-sm-6 col-md-2">
											<li class="mega-menu-column main">
											    <ul>
											    	<li class="dropdown-header"><a style="text-transform: uppercase;" href="{{ URL('bo-mon/'.$sport->alias) }}">{{ $sport->name }}</a></li>
											        <a href="{{ URL('bo-mon/'.$sport->alias) }}">
											        	<img src="{{ asset('resources/upload/images/sport/'.$sport->id.'/'.$sport->image) }}">
											        </a>
													@foreach ($cates as $cate)
														<li><a class="font13" href="{{ URL('bo-mon/'.$sport->alias.'/'.$cate->alias) }}">{{ $cate->name }}</a></li>
													@endforeach
											    </ul>
										    </li>
										</div>
										@endforeach

										<div class="col-sm-6 col-md-2 other-sports">
											<li class="mega-menu-column">
											    <ul>
											    	<li class="dropdown-header other">{{ (session('lang'))?Config::get('lang.'.session('lang'))['other_sport']:Config::get('lang.vi')['other_sport'] }}</li>
											    	<?php $other_sport = DB::table('sports')->where('id', '>', '4')->get(); ?>
											    	@foreach ($other_sport as $osport)
											    		<li><a class="font13" href="{{ URL('bo-mon/'.$osport->alias) }}">{{ $osport->name }}</a></li>
											    	@endforeach
											    </ul>
										    </li>
										</div>
										<!-- /.other-sports -->
									</div>
								</ul>
							</li>
							<li class="dropdown menu-large">
		                        <a href="" class="dropdown-toggle" data-toggle="dropdown">{{ (session('lang'))?Config::get('lang.'.session('lang'))['brand']:Config::get('lang.vi')['brand'] }}<b class="caret"></b></a>
								<ul class="dropdown-menu mega-menu">
									<div class="row">
										<?php
											$brands = DB::table('brands')->whereBetween('id', [1,4])->get();
										?>
										@foreach ($brands as $brand)
										<div class="col-sm-6 col-md-2">
											<li class="mega-menu-column">
											    <ul>
											    	<li class="dropdown-header"><a style="text-transform: uppercase;" href="{{ URL('thuong-hieu/'.$brand->alias) }}">{{ $brand->name }}</a></li>
											        <a href="{{ URL('thuong-hieu/'.$brand->alias) }}">
											        	<img src="{{ asset('resources/upload/images/brand/'.$brand->id.'/'.$brand->image) }}">
											        </a>
											        @foreach ($cates as $cate)
														<li><a class="font13" href="{{ URL('thuong-hieu/'.$brand->alias.'/'.$cate->alias) }}">{{ $cate->name }}</a></li>
													@endforeach
											    </ul>
										    </li>
										</div>
										@endforeach


										<div class="col-sm-6 col-md-2 other-brands">
											<li class="mega-menu-column">
											    <ul>
											    	<li class="dropdown-header other">{{ (session('lang'))?Config::get('lang.'.session('lang'))['other_brand']:Config::get('lang.vi')['other_brand'] }}</li>
													<?php $other_brand = DB::table('brands')->where('id', '>', '4')->get(); ?>
											    	@foreach ($other_brand as $obrand)
											    		<li><a class="font13" href="{{ URL('thuong-hieu/'.$obrand->alias) }}">{{ $obrand->name }}</a></li>
											    	@endforeach
											    </ul>
										    </li>
										</div>
										<!-- /.other-brands -->
									</div>
								</ul>
							</li>
		                    <li><a href="{{ route('getNews') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['news']:Config::get('lang.vi')['news'] }}</a></li>
		                    <li><a href="{{ route('getVideo') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['video']:Config::get('lang.vi')['video'] }}</a></li>
		                    <li><a href="{{ route('getSaleProduct') }}">{{ (session('lang')) ? Config::get('lang.'.session('lang'))['promotion'] : Config::get('lang.vi')['promotion'] }}</a></li>
		                </ul>
		            </nav>
				</div>
			</div>
			<!-- /.my-menu -->

			<div class="search">
				<div class="col-xs-3 col-md-2">
					<form class="form-search top-search" action="{{ route('getSearch') }}">
	                    <input type="text" class="input-medium search-query" name="keyword" placeholder="{{ (session('lang'))?Config::get('lang.'.session('lang'))['search_here']:Config::get('lang.vi')['search_here'] }}" value="">

	                </form>
				</div>
			</div>
			<!-- /.search -->
		</div>



		<!-- /.search -->
</div>
<!-- /.header-bottom -->