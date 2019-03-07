<?php
//
//  �����������,�������360�Լ�������
//

/**
 * 360����������
 *
 */
class NameCreate
{
	
	/*
	  ����: �������͵�������ת�����������ؽ��
	
	*/
	public function processVirusName( $strName , $type )
	{
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		switch( $type )  
		{
			case 'king': 			$result	= $this->processKingName( $strName ); 		break ;
			case 'kingback': 		$result	= $this->processKingName( $strName ); 		break ;
			case 'kaba': 			$result	= $this->processKabaName( $strName ); 		break ;
			case 'rsing': 			$result	= $this->processRsingName( $strName ); 		break ;
			case 'norton': 			$result	= $this->processNortonName( $strName ); 		break ;
			case 'antian': 			$result	= $this->processAntianName( $strName ); 		break ;
			case 'bd': 				$result	= $this->processBitdefenderName( $strName ); 		break ;	 
			case 'nod': 			$result	= $this->processnod32Name( $strName ); 		break ;
			case 'kv': 				$result	= $this->processKvName( $strName ); 		break ;
			case 'cillin': 			$result	= $this->processCillinName( $strName ); 		break ;
		}
		
		return $result ;
	}
	
	/*
	  ���ܣ� ���ݿ�����������360����
	
	  type name : ����
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  Trojan.Win32.BHO.bn||��������.ƽ̨.ľ������.����||Trojan/Win32.BHO.bn||��������/ƽ̨.��������.����
	  			  Trojan-PSW.Win32.OnLineGames.acf||��������.ƽ̨.ľ������.����||Trojan-PSW/Win32.OnLineGames.acf||��������/ƽ̨.��������.����
	  			  not-a-virus:AdWare.Win32.Look2Me.g||��������.ƽ̨.ľ������.����||AdWare/Win32.Look2Me.g||��������/ƽ̨.��������.����||�ֺ�":"ǰ������ֺű������ȫ��ȥ��
	  			  Virus.Win32.Drowor.a||��������.ƽ̨.������.����||Virus/Win32.Drowor.a||��������/ƽ̨.��������.����
	  			  Win32.Hupigon.dev||ƽ̨.������.����||Win32.Hupigon.dev||ƽ̨.��������.����
	  			  Worm.Win32.Viking.bb||��������.ƽ̨.������.����||Worm/Win32.Viking.bb||��������/ƽ̨.��������.����||worm:��没������Ϊľ����	
	  			  
	  	ע�����͵�����ת��ʱ����Ҫ���ڲ���������ƽ̨֮�䣬�ѡ����š��ָ�����Ϊ��/�����ֺš�:������ֺ�ǰ��������Ϣȫ��ȥ����
	*/
	public function processKabaName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				//���ε�
				if( count( $name_arr ) == 3 )
				{
					//��������
					$result['errno']	= 1 ;
					$result['vname']	= $strName ;
				}
				else if( count( $name_arr ) == 4 )
				{
					if( $name_arr[1] == 'Win32' )
					{
						//��һ���к��� �� �ŵ�						
						if( strpos( $name_arr[0], ":") )
						{
							$name_stack_1_arr	= explode( ":", $name_arr[0] ) ;
							$str_arr_temp[0]	= $name_stack_1_arr[1] . "/" . $name_arr[1]	;			//ȥ���� ��ǰ�������
							$str_arr_temp[1]	= $name_arr[2] ;
							$str_arr_temp[2]	= $name_arr[3] ;
						}
						else 
						{
							$str_arr_temp[0]	= $name_arr[0] . "/" . $name_arr[1] ;
							$str_arr_temp[1]	= $name_arr[2] ;
							$str_arr_temp[2]	= $name_arr[3] ;
						}
						
						$result['errno']	= 1 ;
						$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
					}
				}
				else  if( count( $name_arr ) == 5 )
				{
					$str_arr_temp[0]	= $name_arr[0] . "/" . $name_arr[1] ;
					$str_arr_temp[1]	= $name_arr[2] ;
					$str_arr_temp[2]	= $name_arr[3] ;
					$str_arr_temp[3]	= $name_arr[4] ;
					
					$result['errno']	= 1 ;
					$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
				}
				else 
				{
					$result['vname']	= $strName ;
				}
			}
		}
		
		return $result ;
		
	}
	
	
	/*
	  ���ܣ� ���ݽ�ɽ��������360����
	
	  type name : ��ɽ
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  Win32.TrojDownloader.Agent.49152||ƽ̨.��������.��������.�ļ���С||TrojanDownloader/Win32.Agent||��������/ƽ̨.��������.����||�ļ���С���������ֲ��������
				  Win32.Troj.Delf.174080||ƽ̨.��������.��������.�ļ���С||Trojan/Win32.Delf||��������/ƽ̨.��������.����||"Troj"�ĳ�"Trojan"
				  Worm.MYGOD.a.30001||��������.��������.����.�ļ���С||Worm/Win32.MYGOD.a||��������/ƽ̨.��������.����
				  Win32.KLdown.c.17560||ƽ̨.��������.����.�ļ���С||Win32.KLdown.c||ƽ̨.��������.���� 
				  Packes.MaskPE.a||��������.��������.����||Packes/Win32.MaskPE.a||��������/ƽ̨.��������.����||�ڲ������ͺ���������ƽ̨
				  
			ע����ɽ����ת��ʱ����Ҫ�ǰ����������ļ���Сȥ����ͬʱ��ƽ̨�ŵ��������ͺ��棬����������ƽ̨֮��ķָ�����Ϊ��/��

	*/
	public function processKingName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				//���ε�
				if( count( $name_arr ) == 3 )
				{
					$str_arr_temp[0]	= $name_arr[0] . "/Win32"  ;
					$str_arr_temp[1]	= $name_arr[1] ;
					if( !is_numeric( trim( $name_arr[2] ) ) )
					{
						$str_arr_temp[2]	= $name_arr[2] ; 
					}
				}
				else if( count( $name_arr ) == 4 )
				{
					if( $name_arr[0] == 'Win32' )
					{
						//
						if( $name_arr[1] == 'Troj' )
						{
							$str_arr_temp[0]	= "Trojan/" . $name_arr[0] ;
						}
						else 
						{
							$str_arr_temp[0]	= $name_arr[1] . "/" . $name_arr[0] ;
						}
						
						$str_arr_temp[1]	= $name_arr[2] ;
					}	
					else if( $name_arr[0] == 'Worm' ) 
					{
						$str_arr_temp[0]	= $name_arr[0] . "/Win32" ;
						$str_arr_temp[1]	= $name_arr[1] ;
						$str_arr_temp[2]	= $name_arr[2] ;
					}
				}
				else if( count( $name_arr ) == 5 ) 
				{
					if( $name_arr[0] == 'Win32' )
					{
						if( $name_arr[1] == 'Troj' )
						{
							$str_arr_temp[0]	= "Trojan/" . $name_arr[0] ;
						}
						else 
						{
							$str_arr_temp[0]	= $name_arr[1] . "/" . $name_arr[0] ;
						}
						$str_arr_temp[1]	= $name_arr[2] ;
						$str_arr_temp[2]	= $name_arr[3] ;
					}
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
			}
		}
		
		return $result ;		
		
	}
	
	
	/*
	  ���ܣ� ����������������360����
	
	  type name : ����
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  Trojan.DL.Win32.Agent.wsz||��������.������.ƽ̨.��������.����||Trojan-Download/Win32.Agent.wsz||��������/ƽ̨.��������.����||���������������ͺϲ���ͨ����-���ϲ�,DLת��Ϊȫ�ƣ�Download
				Trojan.PSW.Win32.OnlineGames.dre||��������.������.ƽ̨.��������.����||Trojan-PSW/Win32.OnlineGames.dre||��������/ƽ̨.��������.����
				Virus.Win32.SmallDL.a||��������.ƽ̨.��������.����||Virus/Win32.SmallDL.a||��������/ƽ̨.��������.����
				Worm.Agent.xo||��������.������.����||Worm/Win32.Agent.xo||��������/ƽ̨.��������.����
				Trojan.Win32.Dodolook.au||��������.ƽ̨.��������.����||Trojan/Win32.Dodolook.au||��������/ƽ̨.��������.����
				Win32.Brontok.a||ƽ̨.������.����||Win32.Brontok.a||ƽ̨.������.����
				Packer.Mian007||��������.������||Packer/Win32.Mian007||��������/ƽ̨.��������
				Trojan.PSW.QQPass.pmw||��������.������.��������.����||Trojan-PSW/Win32.QQPass.pmw||��������/ƽ̨.��������.����
				Trojan.VB.vvu||��������.��������.����||Trojan/Win32.VB.vvu||��������/ƽ̨.��������.����
				
		ע����������ת��ʱ���������������������ͷ�Ϊ���������������ͣ�360��Ѳ��������������ͽ��кϲ����ϲ����á�-���������ӷ��ţ�����������ƽ̨֮��ķָ�����Ϊ��/�����������е�"DL"��д����Ϊ"Download"
				
	*/
	public function processRsingName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				//2�ε�
				if( count( $name_arr ) == 2 )
				{
					$str_arr_temp[0]	= $name_arr[0] . "/Win32"  ;
					$str_arr_temp[1]	= $name_arr[1] ;
				}
				else if( count( $name_arr ) == 3 )
				{
					if( $name_arr[0] = 'Win32' )
					{
						$str_arr_temp[0]	= $name_arr[0] ;
					}
					else 
					{
						$str_arr_temp[0]	= $name_arr[0] . "/Win32"  ;
					}					
					$str_arr_temp[1]	= $name_arr[1] ;
					$str_arr_temp[2]	= $name_arr[2] ;
				}
				else if( count( $name_arr ) == 4 )
				{
					if( $name_arr[1] == 'Win32' )
					{
						$str_arr_temp[0]	= $name_arr[0] . "/" . $name_arr[1] ;
					}	
					else 
					{
						$str_arr_temp[0]	= $name_arr[0] . "-" . $name_arr[1] . "/Win32"  ;
					}
					$str_arr_temp[1]	= $name_arr[2] ;
					$str_arr_temp[2]	= $name_arr[3] ;
				}
				else if( count( $name_arr ) == 5 )
				{
					if( $name_arr[1] == 'DL' )
					{
						$str_arr_temp[0]	= $name_arr[0] . "-Download/" . $name_arr[2]  ;
					}
					else 
					{
						$str_arr_temp[0]	= $name_arr[0] . "-" . $name_arr[1] . "/" . $name_arr[2]  ;
					}
					$str_arr_temp[1]	= $name_arr[3] ;
					$str_arr_temp[2]	= $name_arr[4] ;
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
				
			}
		}
		
		return $result ;		
		
	}
	
	
	/*
	   ���ܣ� ����Bitdefender��������360����
	
	  type name : Bitdefender
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			 Dropped:Generic.Malware.dld!.1D92B3C6||����.������.����.�����־||Generic/Win32.Malware.dld||��������/ƽ̨.��������.����||�ֺ�":"ǰ������ֺű������ȫ��ȥ����������ȥ��
				Generic.Onlinegames.2.B87B0B9F||����.������.����.�����־||Generic/Win32.Onlinegames.2||��������/ƽ̨.��������.����
				Trojan.Peed.IBY||��������.������.����||Trojan/Win32.Peed.IBY||��������/ƽ̨.������.����
				Trojan.PWS.Onlinegames.AYD||��������.������.������.����||Trojan-PWS/Win32.Onlinegames.AYD||��������/ƽ̨.������.����
				Win32.Worm.Viking.IZ||ƽ̨.��������.������.����||Worm/Win32.Viking.IZ||��������/ƽ̨.������.����
				Win32.Almsfir.VB.A||ƽ̨.��������.������.����||Almsfir/Win32.VB.A||��������/ƽ̨.������.����
				BehavesLike:Win32.ExplorerHijack||ƽ̨.������||Win32.ExplorerHijack||ƽ̨.������||�ֺ�":"ǰ������ֺű������ȫ��ȥ��
				
		ע��bitdefender����ת��ʱ����Ҫȥ����:������ֺ�ǰ���������Ϣ��ȥ�������־��Ϣ���������������������ַ���������ֱ��ȥ����
				
	*/
	public function processBitdefenderName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ":", $strName ) ;
				if( count( $name_arr ) == 2 )
				{
					$name_arr	= $name_arr[1] ;
				}
				else 
				{
					$name_arr	= $name_arr[0] ;
				}
				$name_arr	= explode( ".", $name_arr ) ;
				
				//���ε�
				if( count( $name_arr ) == 2 )
				{
					$str_arr_temp[0]	= $name_arr[0] 	;	
					$str_arr_temp[1]	= $name_arr[1] ;
				}
				else if( count( $name_arr ) == 3 )
				{
					$str_arr_temp[0]	= $name_arr[0] . "/Win32" ;	
					$str_arr_temp[1]	= $name_arr[1] ;	
					$str_arr_temp[2]	= $name_arr[2] ;	
				}
				else if( count( $name_arr ) == 4 )
				{
					if( $name_arr[0] == "Win32" )
					{
						$str_arr_temp[0]	= $name_arr[1] . "/" . $name_arr[0] ;	
						$str_arr_temp[1]	= $name_arr[2] ;	
						$str_arr_temp[2]	= $name_arr[3] ;
					}
					else 
					{
						//���� "Trojan" ��
						if( $name_arr[0] == "Trojan" )
						{
							$str_arr_temp[0]	= $name_arr[0] . "-" . $name_arr[1] . "/Win32";	
							$str_arr_temp[1]	= $name_arr[2] ;	
							$str_arr_temp[2]	= $name_arr[3] ;
						}
						else 
						{
							$str_arr_temp[0]	= $name_arr[0] . "/Win32";	
							$str_arr_temp[1]	= $name_arr[1] ;	
							$str_arr_temp[2]	= str_replace( "!", "", $name_arr[2] ) ;	// ȥ���������
						}
					}
					
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
			}		
			
		}
		
		return $result ;	
		
	}
	
	
	/*
	  ���ܣ� ����nod32��������360����
	
	  type name : nod32
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  Win32/TrojanDownloader.Zlob.BAP||ƽ̨/��������.��������.����||TrojanDownloader/Win32.Zlob.BAP||��������/ƽ̨.������.����
				  Win32/Drowor.NAB||  ||Win32.Drowor.NAB||ƽ̨.��������.����
				  
		  ע��nod32����ת��ʱ���Ѳ���������ƽ̨����λ�ã�ͬʱʹ�á�/����Ϊ�ָ���
				  
	*/
	public function processnod32Name( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				//���ε�
				if( count( $name_arr ) == 1 )
				{
					$name_stack_1_arr	= explode( "/", $name_arr[0] ) ;
					$str_arr_temp[0]	= $name_stack_1_arr[0] ;	
					$str_arr_temp[1]	= $name_stack_1_arr[1] ;
				}
				else if( count( $name_arr ) == 2 )
				{
					$name_stack_1_arr	= explode( "/", $name_arr[0] ) ;
					$str_arr_temp[0]	= $name_stack_1_arr[0] 	;	
					$str_arr_temp[1]	= $name_stack_1_arr[1] ;
					$str_arr_temp[2]	= $name_arr[1] ; 		
				}
				else if( count( $name_arr ) == 3 )
				{
					$name_stack_1_arr	= explode( "/", $name_arr[0] ) ;
					$str_arr_temp[0]	= $name_stack_1_arr[1] . "/" . $name_stack_1_arr[0] ;	
					$str_arr_temp[1]	= $name_arr[1] ;	
					$str_arr_temp[2]	= $name_arr[2] ;	
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
			}		
			
		}
		
		return $result ;
		
	}
	
	
	/*
	  ���ܣ� ����ŵ����������360����
	
	  type name : ŵ��
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  	Trojan||��������||Trojan/Win32||��������/ƽ̨
					W32.Wullik@mm||ƽ̨.������@����||Win32.Wullik@mm||ƽ̨.������.����||W32��Ҫ����ΪWin32
					W32.Mumawow.F||ƽ̨.������.����||Win32.Mumawow.F||ƽ̨.������.����
					W32.Drom||ƽ̨.������||Win32.Drom||ƽ̨.������.����
					Infostealer.Gampass||��������.��������||Infostealer/Win32.Gampass||��������/ƽ̨.��������
					Downloader||��������||Downloader/Win32||��������/ƽ̨
					W32.Spybot.Worm||ƽ̨.������.��������||Worm/Win32.Spybot||��������/ƽ̨.��������
	  			  
	  	ע��ŵ�ٵ�����������ŵ������̫����ͳ��������ϸ�£���˷�Ϊ���������ֻ�С��������͡�����Ҫ���롰ƽ̨���á�/���ָ���W32ƽ̨��Ҫ����Ϊ��Win32�������С�worm���Ĳ����������Ѳ������͵�������ǰ�棬Ȼ����ƽ̨�벡������
	  			  
	*/
	public function processNortonName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				//���ε�
				if( count( $name_arr ) == 1 )
				{
					$str_arr_temp[0]	= $name_arr[0] . "/Win32" ;		
				}
				else if( count( $name_arr ) == 2 )
				{
					if( $name_arr[0] == "W32" )
					{
						$str_arr_temp[0]	= "Win32" ;						
					}
					else 
					{
						$str_arr_temp[0]	= $name_arr[0] . "/Win32" ;		
					}
					$str_arr_temp[1]	= $name_arr[1] ;	
				}
				else if( count( $name_arr ) == 3 )
				{
					if( $name_arr[2] == 'Worm' )
					{
						if( $name_arr[0] == "W32" )
						{
							$str_arr_temp[0]	= "Worm/Win32" ;		
							$str_arr_temp[1]	= $name_arr[1] ;	
						}
					}
					else 
					{
						if( $name_arr[0] == "W32" ) 
						{
							$str_arr_temp[0]	= "Win32" ;		
							$str_arr_temp[1]	= $name_arr[1] ;	
							$str_arr_temp[2]	= $name_arr[2] ;	
						}
						else if( $name_arr[1] == "W32" )
						{
							$str_arr_temp[0]	= "Win32" ;		
							$str_arr_temp[1]	= $name_arr[0] ;	
							$str_arr_temp[2]	= $name_arr[2] ;
						}
						else 
						{
							$str_arr_temp[0]	= $name_arr[0] . "/Win32" ;		
							$str_arr_temp[1]	= $name_arr[1] ;	
							$str_arr_temp[2]	= $name_arr[2] ;
						}
					}
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
			}		
			
		}
		
		return $result ;
		
	}
	
	
	/*
	  ���ܣ� ���ݰ�����������360����
	  
	  type name : ����
	  ��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
	  ������Ŀ	: 
	  			  Trojan/Win32.Zlob.b[Downloader]||��������/ƽ̨.��������.����||Trojan/Win32.Zlob.b||��������/ƽ̨.��������.����||"[]"�������е�����ȥ��

	  	ע����������������Ǵ���һ����ֻ��Ҫ�ѡ�[]���е������Լ�������һͬȥ�����ɡ�����ͣ��	  
	  	
	*/
	public function processAntianName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
			
				if( count( $name_arr ) == 2 )
				{
					$name_stack_1_arr	= explode( "/", $name_arr[0] ) ;
					$str_arr_temp[0]	= $name_stack_1_arr[0] . "/Win32" ;
					$str_arr_temp[1]	= $name_stack_1_arr[1] ;		//ȥ��[]������ 
				}
				else if( count( $name_arr ) == 3 )
				{
					$str_arr_temp[0]	= $name_arr[0] 	;	
					$str_arr_temp[1]	= $name_arr[1] ;
					$name_stack_1_arr	= explode( "[", $name_arr[2] ) ;
					$str_arr_temp[2]	= $name_stack_1_arr[0] ;		//ȥ��[]������
				}
				
				$result['errno']	= 1 ;
				$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
			}			
		}
		
		return $result ;
		
	}
	
	/*
		����: ���ݽ�����������360����
	
		type name : ���� kv
		��ͷ		: ��������||������������||360����ʵ��||360��������||��ע 
		������Ŀ	: 
			TrojanSpy.Agent.sl	��������.������.����	TrojanSpy/win32.Agent.sl	��������/ƽ̨.������.����	��ӡ�ƽ̨��Ϣ��-��Win32��
			Adware/Adload.ad	��������/��������.����	Adware/Win32.Adload.ad	��������/ƽ̨.������.����	��ӡ�ƽ̨��Ϣ��-��Win32��
			Trojan/BHO.Gen	��������/��������.����	Trojan/Win32.BHO.Gen	��������/ƽ̨.������.����	��
			Backdoor/Huigezi.2006.fhd	��������/��������.��������.����	Backdoor/win32.Huigezi.2006.fhd	��������/ƽ̨.��������.��������.����	��
			Adware/Qnsou	��������/��������	Adware/win32.Qnsou	��������/ƽ̨.��������	��
			TrojanDownloader.Agent.hge	��������.��������.����	TrojanDownloader/Win32.Agent.hge	��������/ƽ̨.������.����	
			I-Worm/Nuwar.a	��������.��������.����	I-Worm/win32.Nuwar.a	��������/ƽ̨.������.����	���ˣ�����ľ���
			Trojan/PSW.QQRobber.im	��������/������.��������.����	Trojan/Win32.PSW.QQRobber.im	��������/ƽ̨.������.��������.����	
			Win32/Alaqq.1371	ƽ̨/��������.����	Win32.Alaqq.1371	ƽ̨.��������.����	
			Worm/Viking.aeo	��������.��������.����	Worm/win32Viking.aeo	��������/ƽ̨.������.����	���ˣ�����ľ���
			ע������������ʽΪ������������/�������ơ�  ����������/��������.���֡� ����������/������.��������.���֡� ����������/�������� �����������ģ���/�����涼Ҫ��� ƽ̨��Ϣ "Win32" .
	*/ 
	public function processKvName( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
				
				if( !empty( $name_arr ) )
				{
					foreach ( $name_arr as $idx => $name_info )
					{
						if( $idx == 0 )
						{
							if( strpos( $name_info, "/") )
							{
								$name_stack_1_arr	= explode( "/", $name_info ) ;
								if( $name_stack_1_arr[0] != 'Win32' )
								{
									$str_arr_temp[]	= $name_stack_1_arr[0] . "/Win32" ;
								}
								else 
								{
									$str_arr_temp[]	= "Win32" ;
								}
								$str_arr_temp[]	= $name_stack_1_arr[1] ;
							}
							else 
							{
								$str_arr_temp[]	= $name_info . "/Win32" ;
							}
						}
						else  
						{
							$str_arr_temp[]	= $name_info ;
						}
					}
					
					$result['errno']	= 1 ;
					$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
				}		
			}			
		}
		
		return $result ;
		
	}
	
	/*
		����: ����������������360����
	
		type name : ���� cillin
		��ͷ		: ��������||������������||360����ʵ��||360��������||��ע
		������Ŀ	: 
			Adware_Boran	��������_��������	Adware/Win32.Boran	��������/ƽ̨.��������	
			PE_LOOKED.TN	��������_��������.����	PE/Win32.LOOKED.TN	��������/ƽ̨.��������.����	
			PE_LOOKED.UN-O	��������_��������.����-����ȷ���ֶ�	PE/Win32.LOOKED.UN	��������/ƽ̨.��������.����	�� -����ȷ���ֶΡ�ȥ�������ֶβ���Ӳ�ת��
			Possible_MLWR-1	��������_��������-����ȷ���ֶ�	Possible/Win32.MLWR	��������/ƽ̨.��������-����ȷ���ֶ�	��
			PE_LOOKED.O-O	��������_��������-����ȷ���ֶ�	PE/Win32.LOOKED.O	��������/ƽ̨.��������-����ȷ���ֶ�	��
			TROJ_Generic	��������_��������	Trojan/Win32.Generic	��������/ƽ̨.��������	
			Possible_Legmir3	��������_��������	Possible/Win32.Legmir3	��������/ƽ̨.��������	
			Suspicious_File	��������_�ļ�����			�����ݹ��ˣ�����ľ��⣻
			WORM_SDBOT.CNF	��������_��������.����	WORM/Win32.SDBOT.CNF	��������/ƽ̨.��������.����	
			ע��1���������ƴ󲿷�����Ϊ��д��Ϊͳһ��ʽ�����æ������ת����ÿ���ʵĵ�һ��ĸΪ��д������ΪСд,���һ����ȫ��ΪСд�����磺TROJ_DLOADER.NFM ת���� Troj_Dloader.nfm���� 2��TROJ����Ϊȫ�ƣ�Trojan �� 3�����˹ؼ������ټ��롰Suspicious�����ɵģ����ɵģ�										
	*/
	public function processCillinName( $strName ) 
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	array( 'errno' => 0/1, 'vname' => '' )		������Ϣ������		0 -- ����ľ���ת��ʧ��  1 -- ת���ɹ� 
		 *
		 */ 
		
		$result	= array(
			'errno'		=> '0',
			'vname'		=> '',
		) ;
		
		if( empty( $strName ) )
		{
			return $result ;
		}
		else 
		{
			// �������һЩ�ؼ��� �� ��ֱ��return
			if( $this->keywordFilter( $strName ) )
			{
				$result['vname']	= $strName ;
			}
			else 
			{
				$str_arr_temp	= array() ;			//���ɵ���������
				//�ָ��ַ���
				$name_arr	= explode( ".", $strName ) ;
			
				if( !empty( $name_arr ) )
				{
					$count	= count( $name_arr ) ;
					foreach ( $name_arr as $idx => $name_info )
					{
						if( $idx == 0 )
						{
							if( strpos( $name_info, "_") )
							{
								$name_stack_1_arr	= explode( "_", $name_info ) ;
								if( $name_stack_1_arr[0] == "PE" )
								{
									$str_arr_temp[]	= $name_stack_1_arr[0] . "/Win32" ;
								}
								else if( $name_stack_1_arr[0] == "TROJ" )
								{
									$str_arr_temp[]	= "Trojan/Win32" ;
								}
								else 
								{
									$str_arr_temp[] = $this->strConvertTo( $name_stack_1_arr[0] ). "/Win32" ;
								}
								
								$name_stack_2_arr	= explode( "-", $name_stack_1_arr[1] ) ;
								$str_arr_temp[]	= $this->strConvertTo( $name_stack_2_arr[0] ) ;
							}
							else 
							{
								$str_arr_temp[]	= $this->strConvertTo( $name_info ) . "/Win32" ;
							}
						}
						else if( $idx == ($count-1) )   //���һλȫ��Сд
						{
							$name_stack_1_arr	= explode( "-", $name_info ) ;
							$str_arr_temp[]	= strtolower( $name_stack_1_arr[0] ) ;
						}
						else 
						{
							$str_arr_temp[]	= $this->strConvertTo( $name_info ) ;
						}
						
					}
					
					$result['errno']	= 1 ;
					$result['vname']	= $this->array_to_name( $str_arr_temp ) ;
				}	
			}			
		}
		
		return $result ;
		
	}
	
	/*
		���ܣ� �ؼ����ж�
			  ��������¹ؼ��ʣ�������Ϊľ�����ݵ�����
		
		Crack||��ɽ��Ʒ��||Win32.Troj.CrackCiba.b.686080
		RavFree||���Ǳ�ķ||Win32.Hack.RavFree.pq.353280��Win32.NotVirus.RavFree.qx.884736
		RiskWare||���ճ���||Win32.RiskWare.DownWinFixer.u.84738
		worm||��没��||W32.Spybot.Worm ��ŵ����������W32.Rontokbro@mm ��ŵ����������Worm.Win32.Viking.ls
		Email-Worm||��没��||Email-Worm.Win32.Runouce.b������������
		Virus||����||Virus.Win32.Delf.bz
	
	*/
	public function keywordFilter( $strName )
	{
		/**
		 *  [in]	--	$strName		��������
		 *  [out]	--	true/false
		 */
		
		// �����ַ���������
		$str_keyword	= "/(Crack|crack|RavFree|RiskWare|riskware|worm|Worm|WORM|Email-Worm|Virus|virus|Virut|Parite|Suspicious|Sniffer|CCProxy|CrackCiba|Unknown)/" ;   //i ��ʶ�����ִ�Сд
		
		if( empty( $strName ) )
		{
			return true ;
		}
		
		if( preg_match( $str_keyword, $strName ) ) 
		{
			return true ;
		}
		
		return false ;		
	}
	
	/**
	 * 
	 *	������������ľ������
	 *
	 */
	public function array_to_name( $name_arr )
	{
		/*
			[in]	-- 		$name_arr = array()  ����	
			[out]	--  	strname	 ľ������
		*/
		$strname	= "" ;
		
		if( !empty( $name_arr ) )
		{
			$count	= count( $name_arr ) ;
			foreach ( $name_arr as $id => $datainfo )
			{
				if( $count == $id+1 ) 
				{
					$strname	.= $datainfo ;
				}
				else 
				{
					$strname	.= $datainfo . "." ;
				}				
			}
		}
		
		return $strname ;		
	}
	
	/**
	 * ת������Ϊ��һ����ĸ��д,����Сд
	 */
	public function strConvertTo( $strname )
	{
		$result	= "" ;
		if( !empty( $strname ) )
		{
			$strname	= strtolower( $strname ) ;
			$len		= strlen( $strname ) ;
			$strhead	= strtoupper( substr( $strname, 0, 1 ) ) ;
			$strtail	= substr( $strname, 1 ) ;
			
			$result	= $strhead . $strtail ;			
		}
		
		return $result ;
	}
	
}



?>
