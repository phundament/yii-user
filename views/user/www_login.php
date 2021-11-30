<div class="login-container">
							<div class="row-fluid">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header blue lighter bigger">
													<i class="icon-coffee green"></i>
													<?php echo UserModule::t("Please login with your credentials:"); ?>
												</h4>
                                                <?php echo CHtml::errorSummary($model); ?>
												<div class="space-6"></div>

												<?php echo CHtml::beginForm($action= 'http://localhost.parkoil/index.php?r=user/login&lang=en', 
                                                                                                                            $method='post', 
                                                                                                                            $htmlOptions =array ('target' => '_blank')       ); ?>
													<fieldset>
														<label>
															<span class="block input-icon input-icon-right">
																<input type="text" class="span12" placeholder="Username" name="UserLogin[username]"/>
																<i class="icon-user"></i>
															</span>
														</label>

														<label>
															<span class="block input-icon input-icon-right">
																<input type="password" class="span12" placeholder="Password" name="UserLogin[password]"/>
																<i class="icon-lock"></i>
															</span>
														</label>

														<div class="space"></div>

														<div class="clearfix">
                                                            <?php $this->widget('bootstrap.widgets.TbButton', array(
                                                                'label'=>UserModule::t("Login"),
                                                                'buttonType'=>'submit', 
                                                                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                                                                //'size'=>'large', // null, 'large', 'small' or 'mini'
                                                                'icon'=>'icon-key',
                                                                'htmlOptions'=> array('class' => 'width-35 pull-right btn btn-small btn-primary'),
                                                            )); ?>                                                            
														</div>

														<div class="space-4"></div>
													</fieldset>
												</form><?php echo CHtml::endForm(); ?>

                                                <?php
                                                    $form = new CForm(array(
                                                        'elements'=>array(
                                                            'username'=>array(
                                                                'type'=>'text',
                                                                'maxlength'=>200,
                                                            ),
                                                            'password'=>array(
                                                                'type'=>'password',
                                                                'maxlength'=>32,
                                                            ),
                                                        ),

                                                        'buttons'=>array(
                                                            'login'=>array(
                                                                'type'=>'submit',
                                                                'label'=>'Login',
                                                            ),
                                                        ),
                                                    ), $model);
                                                    ?>
                                                
											</div><!-- /widget-main -->

										</div><!-- /widget-body -->
									</div><!-- /login-box -->
                                                        </div>
</div>
								
