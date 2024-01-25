@extends('layouts.header')

@section('title','Control Panel - Statistics')

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/control_panel/all.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection


@section('body')

<div class="theme-layout">
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="row justify-content-center" id="page-contents">
							<div class="col-lg-11">
								<div class="central-meta text-center">
                  <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-layer-group" style="font-size: 25px;"></i> Statistics </h2>

                  <div class="card-body">
                      <div class="container">
                          <div class="row">
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-primary">
                                <div class="card-body bg-primary text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa-solid fa-circle-question fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\Question::count() }}</h1></h1>
                                      <h4>Questions</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-primary">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-secondary">
                                <div class="card-body bg-secondary text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa fa-user-graduate fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1>{{ \App\Models\User::count() }}</h1>
                                      <h4>Students</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-secondary">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-success">
                                <div class="card-body bg-success text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa fa-user-tie fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\User::where('role','supervisor')->count() }}</h1></h1>
                                      <h4>Supervisors</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-success">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-danger">
                                <div class="card-body bg-danger text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\Course::count() }}</h1></h1>
                                      <h4>Courses</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-danger">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-warning">
                                <div class="card-body bg-warning text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa fa-university fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\College::count() }}</h1></h1>
                                      <h4>Colleges</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-warning">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-info">
                                <div class="card-body bg-info text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa fa-suitcase fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\Resource::count() }}</h1></h1>
                                      <h4>Resources</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-info">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>

                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-success">
                                <div class="card-body bg-success text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa-solid fa-building fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\University::count() }}</h1></h1>
                                      <h4>Universities</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-info">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>

                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-secondary">
                                <div class="card-body bg-secondary text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa-solid fa-font-awesome fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\Major::count() }}</h1></h1>
                                      <h4>Majors</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-info">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>

                            <div class="col-lg-4 col-md-6" style="margin-top: 20px">
                              <div class="card border-primary">
                                <div class="card-body bg-primary text-white">
                                  <div class="row">
                                    <div class="col-3">
                                      <i class="fa-solid fa-rocket fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                      <h1><h1>{{ \App\Models\Major::count() }}</h1></h1>
                                      <h4>Workspaces</h4>
                                    </div>
                                  </div>
                                </div>
                                <a href="https://www.linkedin.com/in/younes-elmorabit" target="_blank">
                                  <div class="card-footer bg-light text-info">
                                    <span class="float-left">More details</span>
                                    <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
            
                  </div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection

@section('modal')

@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
