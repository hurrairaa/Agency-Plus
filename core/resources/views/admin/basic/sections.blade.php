@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Section Customization</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Home Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Section Customization</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.sections.update')}}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-title">Customize Sections</div>
                </div>
            </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <div class="form-group">
                  <label>Feature Section **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="feature_section" value="1" class="selectgroup-input" {{$abs->feature_section == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="feature_section" value="0" class="selectgroup-input" {{$abs->feature_section == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <label>Introduction Section **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="intro_section" value="1" class="selectgroup-input" {{$abs->intro_section == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="intro_section" value="0" class="selectgroup-input" {{$abs->intro_section == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <label>Service Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="service_section" value="1" class="selectgroup-input" {{$abs->service_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="service_section" value="0" class="selectgroup-input" {{$abs->service_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Approach Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="approach_section" value="1" class="selectgroup-input" {{$abs->approach_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="approach_section" value="0" class="selectgroup-input" {{$abs->approach_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Statistics Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="statistics_section" value="1" class="selectgroup-input" {{$abs->statistics_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="statistics_section" value="0" class="selectgroup-input" {{$abs->statistics_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Portfolio Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="portfolio_section" value="1" class="selectgroup-input" {{$abs->portfolio_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="portfolio_section" value="0" class="selectgroup-input" {{$abs->portfolio_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Testimonial Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="testimonial_section" value="1" class="selectgroup-input" {{$abs->testimonial_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="testimonial_section" value="0" class="selectgroup-input" {{$abs->testimonial_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Team Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="team_section" value="1" class="selectgroup-input" {{$abs->team_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="team_section" value="0" class="selectgroup-input" {{$abs->team_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Pricing Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="pricing_section" value="1" class="selectgroup-input" {{$abe->pricing_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="pricing_section" value="0" class="selectgroup-input" {{$abe->pricing_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>News Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="news_section" value="1" class="selectgroup-input" {{$abs->news_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="news_section" value="0" class="selectgroup-input" {{$abs->news_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Call to Action Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="call_to_action_section" value="1" class="selectgroup-input" {{$abs->call_to_action_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="call_to_action_section" value="0" class="selectgroup-input" {{$abs->call_to_action_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Partners Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="partner_section" value="1" class="selectgroup-input" {{$abs->partner_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="partner_section" value="0" class="selectgroup-input" {{$abs->partner_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Top Footer Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="top_footer_section" value="1" class="selectgroup-input" {{$abs->top_footer_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="top_footer_section" value="0" class="selectgroup-input" {{$abs->top_footer_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
                <div class="form-group">
                  <label>Copyright Section **</label>
                  <div class="selectgroup w-100">
										<label class="selectgroup-item">
											<input type="radio" name="copyright_section" value="1" class="selectgroup-input" {{$abs->copyright_section == 1 ? 'checked' : ''}}>
											<span class="selectgroup-button">Active</span>
										</label>
										<label class="selectgroup-item">
											<input type="radio" name="copyright_section" value="0" class="selectgroup-input" {{$abs->copyright_section == 0 ? 'checked' : ''}}>
											<span class="selectgroup-button">Deactive</span>
										</label>
									</div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
