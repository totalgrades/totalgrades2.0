                      
                    
                      <div class="table-responsive">
                          <table class="table table-bordered text-center table-hover" table-responsive>
                            <thead>
                            <tr class="info">
                              <th colspan="1" class="text-center">SUBJECTS</th>
                              <th colspan="1" class="text-center">TOTAL SCORE</th>
                              <th colspan="3" class="text-center">CLASS STATISTICS</th>
                              <th colspan="1" class="text-center">STUDNET</th>
                              <th colspan="1" class="text-center">LETTER</th>
                              
                            </tr>
                            <tr class="info">
                              <th class="text-center">NAME-CODE</th>
                              <th class="text-center">100%</th>
                              <th class="text-center">HIGHEST</th>
                              <th class="text-center">LOWEST</th>
                              <th class="text-center">AVERAGE</th>
                              <th class="text-center">POSITION</th>
                              <th class="text-center">GRAGE</th>

                            </tr>
                          </thead>
                            <tbody>
                            

                                @foreach($courses as $course)
                                    @foreach ($course_grades->where('course_id', $course->id) as $grade)
                                                                    

                                      <tr>
                                        

                                        
                                        <td class="text-center">{{$course->name}}-{{$course->course_code}}</td>
                                          
                                        <td class="text-center">{{$grade->total}} %</td>
                                                        
                                        <td class="text-center">

                                        


                                        </td>
                                       
                                        <td class="text-center">

                                       
                                        </td>

                                        <td class="text-center">

                                        
                                        </td>

                                        <td class="text-center">

                                       


                                        </td>


                                        <td class="text-center">

                                            
                                            @if ($grade->total < 65)
                                            F
                                            @elseif ($grade->total<= 66 && $grade->total >=65)
                                            D
                                            @elseif ($grade->total<= 69 && $grade->total >=67)
                                            D+
                                            @elseif ($grade->total<= 73 && $grade->total >=70)
                                            C-
                                            @elseif ($grade->total<= 76 && $grade->total >=74)
                                            C
                                            @elseif ($grade->total<= 79 && $grade->total >=77)
                                            C+
                                            @elseif ($grade->total<= 83 && $grade->total >=80)
                                            B-
                                            @elseif ($grade->total<= 86 && $grade->total >=84)
                                            B
                                            @elseif ($grade->total<= 89 && $grade->total >=87)
                                            B+
                                            @elseif ($grade->total<= 93 && $grade->total >=90)
                                            A-
                                            @elseif ($grade->total<= 96 && $grade->total >=94)
                                            A
                                            @elseif ($grade->total>= 97)
                                            A+
                                            @endif

                                         
                                        </td>
                                      
                                      </tr>

                                                
                                      @endforeach
                                       
                                   
                                @endforeach
                          
                            </tbody>
                          </table>
                        </div>
                