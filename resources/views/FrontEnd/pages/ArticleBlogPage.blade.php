@extends('layouts.master',['title' => 'Blog Details'])
    @section('content')
    @if(isset($blogdetails) )
        <div id="parallax">
            <img id="blog-details-layer-1"  class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="blog-details-layer-2"  class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
        </div>
    <section class="home-page-banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="banner">
                                    @if(isset($blogdetails['banner_image']))
                                        <img src="{{ asset($blogdetails['banner_image']) }} ">
                                    @else
                                        <img src="<img src="{{ asset('images/article-page.jpg') }}">
                                    @endif
                                </div>
                                @php
                                    $socials = getSocialDetails();
                                @endphp
                                <div class="social">
                                    <ul>
                                        @if(isset($socials) && $socials != '')
                                            @foreach($socials as $socialdetails)
                                                @if($socialdetails->icon != '')
                                                    <li><a href="{{$socialdetails->account_url}}" target="_blank"><i class="{{$socialdetails->icon}}"></i></a></li>
                                                @else($socialdetails->image != '')
                                                    <li><a href="{{$socialdetails->account_url}}"><img src="{{asset($socialdetails->image)}}"></a> </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="breadcrumb-block">
                    <div class="container">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('Blog') }}">BLOG</a></li>
                            <li><a  class="active">{{$blogdetails['title']}}</a></li>
                        </ul>
                        <div class="share-btns">
                            <a data-toggle="modal" data-target="#share_modal" class="a2a_dd" href="#"><i class="fal fa-share"></i></a>
                           <!--  <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <a class="a2a_dd" href="https://www.addtoany.com/share"><i class="fal fa-share"></i></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script> -->
                        </div>
                    </div>
                </section>


            <section class="article-profile">
                <div class="container">
                        <div class="row text-center">
                        <div class="col-md-9 mx-auto">
                            <h2 class="wow fadeIn" data-wow-duration="0.8s" data-wow-delay="0.5s">{{$blogdetails['title']}}</h2>
                            <div class="artical-date gradient-pink-text wow fadeIn" data-wow-duration="0.8s" data-wow-delay="0.8s">
                                @php

                                    $date=date_create($blogdetails['date']);
                                    echo $date =  date_format($date,"d/m/Y");
                                @endphp
                            </div>
                           @php echo $blogdetails['content']; @endphp
                           <h3>{{$blogdetails['short_content']}}</h3>
                        </div>
                        </div>
                </div>
            </section>

            <section class="article-blog">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="artical-item">
                                <div class="article-img">
                                    @if(isset($blogdetails['column1_image']))
                                        <img src="{{ asset($blogdetails['column1_image']) }} ">
                                    @else
                                        <img src="<img src="{{ asset('images/article-1.jpg') }}">
                                    @endif
                                </div>
                                <div class="article-detail">
                                    <h3 class="article-title gradient-pink-text">{{$blogdetails['column1_title']}}</h3>
                                    <p>@php echo $blogdetails['column1_description']; @endphp</p>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="artical-item">

                                <div class="article-img">
                                    @if(isset($blogdetails['column2_image']))
                                        <img src="{{ asset($blogdetails['column2_image']) }} ">
                                    @else
                                        <img src="<img src="{{ asset('images/article-2.jpg') }}">
                                    @endif
                                </div>
                                <div class="article-detail">
                                    <h3 class="article-title gradient-pink-text">{{$blogdetails['column2_title']}}</h3>
                                    <p>@php echo $blogdetails['column2_description']; @endphp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="video-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 video-desc mx-auto text-center">
                            <h3 class="video-text gradient-pink-text">“{{$blogdetails['quote']}}”</h3>

                            <div class="video-banner">
                               
                                    @if($blogdetails['media_type'] == 'image')
                                        @if(isset($blogdetails['image']))
                                            <img  src="{{ asset($blogdetails['image']) }}">
                                        @else
                                            <img src="{{ asset('images/article-page.jpg') }}">
                                        @endif
                                    @else
                                        @if(isset($blogdetails['video']))
                                            <iframe  src="{{$blogdetails['video']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @else
                                            <iframe  src="https://www.youtube.com/embed/C0DPdy98e4c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @endif
                                        
                                    @endif

                                
{{--                                <span class="play-button"><i class="fas fa-play"></i></span>--}}
                            </div>

                            </div>

                        </div>
                    </div>
            </section>

                @if(isset($relatedblogs) && count($relatedblogs) > 0)
                <section class="related-articles">
                    <div class="container">
                        <span class="sub-heading text-white">Related</span>
                        <h2 class="text-white">Articles</h2>
                        <div class="articles-slider">
                            @foreach($relatedblogs as $relatedblogsdetails)
                            <div class="articles-item">
                                <div class="articles-img">
                                    @if(isset($relatedblogsdetails['banner_image']))
                                        <img src="{{ asset($relatedblogsdetails['banner_image']) }} ">
                                    @else
                                        <img src="<img src="{{ asset('images/article/related-article-1.jpg') }}">
                                    @endif
                                </div>
                                <div class="articles-desc">
                                    <h3 class="article-name">{{$relatedblogsdetails['title']}}</h3>
                                    <span class="artical-date gradient-blue-text">
                                        @php
                                            $blogid = base64_encode($relatedblogsdetails['blog_id']);
                                                $date=date_create($relatedblogsdetails['date']);
                                                echo $date =  date_format($date,"d/m/Y");
                                                echo $relatedblogsdetails['id'];
                                        @endphp
                                    </span>
                                    <div class="articles-detail">
                                        <p>
                                            {{ str_limit($relatedblogsdetails['quote'], $limit = 100, $end = '')}}</p>
                                        <a class="btn common-btn" href="{{ route('ArticleBlogPage',['slug' =>  $blogid])}}">read more</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                     <!-- Modal -->
                    <div id="share_modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                                <h2>Share page</h2> 

                            <div class="share_button">
                         
                             <a class="modal-close" data-dismiss="modal"><img src="{{asset('images/modal-close.svg')}}"></a>

                       <button class="btn white-btn" onclick="redirect_facebook('{{Request::url()}}','{{$blogdetails['title']}}')">
                                <span class="gradient-pink-text"> <i class="fab fa-facebook-f"></i>  share on facebook</span>
                        </button>

                        <button class="btn white-btn" onclick="redirect_instagram('https://www.instagram.com/')">
                                <span class="gradient-pink-text"> <i class="fab fa-instagram"></i> share on instagram</span>
                        </button>

                        <button class="btn white-btn" onclick="redirect_whatsapp('{{Request::url()}}','{{$blogdetails['title']}}')">
                                <span class="gradient-pink-text"> <i class="fab fa-whatsapp"></i> share in whatsapp</span>
                        </button>

                          </div>
                          <div class="cpy_link">
                            <input type="text" id="copy_link" name="copy_link" value="{{Request::url()}}" readonly>
                            <button class="btn white-btn copy_link" type="button" onclick="copy_text()"><span>copy link</span></button>
                              
                          </div> 
                         
                        </div>

                      </div>
                    </div> 
            <div id="parallax">
                <img id="related-article-layer1"  class="parallax" src="{{asset('images/layers/blue-circle.svg')}}">
            </div>
                </section>
                    @endif
        @endif
    @endsection
@section('page_plugin_script')
    <script type="text/javascript">
        $(window).parallaxmouse({
            invert: true,
            range: 400,
            elms: [ {
                el: $('#blog-details-layer-1'),
                rate: 0.10
            },
            {
                el: $('#blog-details-layer-2'),
                rate: 0.4
            },
            {
                el: $('#related-article-layer1'),
                rate: 0.4
            },

            ]
        });
        function redirect_facebook(url, business) {
        window.location.href = "https://www.facebook.com/sharer/sharer.php?u="+url+"&t="+business+"&quote=";
    }
    function redirect_whatsapp(url, business) {
        window.location.href = "https://api.whatsapp.com/send?text="+url;
    }
    function redirect_instagram(url) {
        window.location.href = url;
    }
    function copy_text() {
      /* Get the text field */
      var copyText = document.getElementById("copy_link");
      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      /* Copy the text inside the text field */
      document.execCommand("copy");
        $.toast({
                heading: 'Success',
                 bgColor: '#007bff',
                hideAfter: 2000,
                text: "Text Copied",
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-right',
            })
    }
    </script>
@endsection