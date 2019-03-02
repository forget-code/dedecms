<?php
/***************************************
*���ߣ�������Ы��beluckly��
*����&MSN��smpluckly@gmail.com
*���ʱ�䣺2006-12-18
*������CreatMiniature
*���ܣ����ɶ������͵�����ͼ
*����������$srcFile,$echoType
*�����õ��Ĳ�����
				$toFile,���ɵ��ļ�
				$toW,���ɵĿ�
				$toH,���ɵĸ�
				$bk1,������ɫ���� ��255Ϊ���
				$bk2,������ɫ����
				$bk3,������ɫ����
*����
	include("creatminiature.php");
	$cm=new CreatMiniature();
	$cm->SetVar("bei1.jpg","file");
	$cm->Distortion("dis_bei.jpg",200,300);
	$cm->Prorate("pro_bei.jpg",200,300);
	$cm->Cut("cut_bei.jpg",200,300);
	$cm->BackFill("fill_bei.jpg",200,300);
***************************************/
class CreatMiniature
{
	//��������
	var $srcFile="";        //ԭͼ
	var $echoType;			//���ͼƬ���ͣ�link--������Ϊ�ļ���file--����Ϊ�ļ�
	var $im="";				//��ʱ����
	var $srcW="";			//ԭͼ��
	var $srcH="";			//ԭͼ��

	//���ñ�������ʼ��
	function SetVar($srcFile,$echoType)
	{
		$this->srcFile=$srcFile;
		$this->echoType=$echoType;

	    $info = "";
	    $data = GetImageSize($this->srcFile,$info);
	    switch ($data[2]) 
	    {
		 case 1:
		   if(!function_exists("imagecreatefromgif")){
		    echo "���GD�ⲻ��ʹ��GIF��ʽ��ͼƬ����ʹ��Jpeg��PNG��ʽ��<a href='javascript:go(-1);'>����</a>";
		    exit();
		   }
		   $this->im = ImageCreateFromGIF($this->srcFile);
		   break;
		case 2:
		  if(!function_exists("imagecreatefromjpeg")){
		   echo "���GD�ⲻ��ʹ��jpeg��ʽ��ͼƬ����ʹ��������ʽ��ͼƬ��<a href='javascript:go(-1);'>����</a>";
		   exit();
		  }
		  $this->im = ImageCreateFromJpeg($this->srcFile);    
		  break;
		case 3:
		  $this->im = ImageCreateFromPNG($this->srcFile);    
		  break;
	  }
	  $this->srcW=ImageSX($this->im);
	  $this->srcH=ImageSY($this->im); 
	}
	
	//����Ť������ͼ
	function Distortion($toFile,$toW,$toH)
	{
		$cImg=$this->CreatImage($this->im,$toW,$toH,0,0,0,0,$this->srcW,$this->srcH);
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
	}
	
	//���ɰ��������ŵ���ͼ
	function Prorate($toFile,$toW,$toH)
	{
		$toWH=$toW/$toH;
		$srcWH=$this->srcW/$this->srcH;
		if($toWH<=$srcWH)
		{
			$ftoW=$toW;
			$ftoH=$ftoW*($this->srcH/$this->srcW);
		}
		else
	    {
			  $ftoH=$toH;
			  $ftoW=$ftoH*($this->srcW/$this->srcH);
	    }
		if($this->srcW>$toW||$this->srcH>$toH)
		{
			$cImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
			return $this->EchoImage($cImg,$toFile);
			ImageDestroy($cImg);
		}
		else
		{
			$cImg=$this->CreatImage($this->im,$this->srcW,$this->srcH,0,0,0,0,$this->srcW,$this->srcH);
			return $this->EchoImage($cImg,$toFile);
			ImageDestroy($cImg);
		}
	}
	
	//������С�ü������ͼ
	function Cut($toFile,$toW,$toH)
	{
		  $toWH=$toW/$toH;
		  $srcWH=$this->srcW/$this->srcH;
		  if($toWH<=$srcWH)
		  {
			   $ctoH=$toH;
			   $ctoW=$ctoH*($this->srcW/$this->srcH);
		  }
		  else
		  {
			  $ctoW=$toW;
			  $ctoH=$ctoW*($this->srcH/$this->srcW);
		  } 
		$allImg=$this->CreatImage($this->im,$ctoW,$ctoH,0,0,0,0,$this->srcW,$this->srcH);
		$cImg=$this->CreatImage($allImg,$toW,$toH,0,0,($ctoW-$toW)/2,($ctoH-$toH)/2,$toW,$toH);
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
		ImageDestroy($allImg);
	}

	//���ɱ���������ͼ
	function BackFill($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)
	{
		$toWH=$toW/$toH;
		$srcWH=$this->srcW/$this->srcH;
		if($toWH<=$srcWH)
		{
			$ftoW=$toW;
		    $ftoH=$ftoW*($this->srcH/$this->srcW);
		}
		else
		{
			  $ftoH=$toH;
			  $ftoW=$ftoH*($this->srcW/$this->srcH);
		}
		if(function_exists("imagecreatetruecolor"))
		{
			@$cImg=ImageCreateTrueColor($toW,$toH);
			if(!$cImg)
			{
				$cImg=ImageCreate($toW,$toH);
			}
		}
		else
		{
			$cImg=ImageCreate($toW,$toH);
		}
		$backcolor = imagecolorallocate($cImg, $bk1, $bk2, $bk3);		//���ı�����ɫ
		ImageFilledRectangle($cImg,0,0,$toW,$toH,$backcolor);
		if($this->srcW>$toW||$this->srcH>$toH)
		{	 
			$proImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
			 if($ftoW<$toW)
			 {
				 ImageCopy($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH);
			 }
			 else if($ftoH<$toH)
			 {
				 ImageCopy($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
			 }
			 else
			 {
				 ImageCopy($cImg,$proImg,0,0,0,0,$ftoW,$ftoH);
			 }
		}
		else
		{
			 ImageCopy($cImg,$this->im,($toW-$ftoW)/2,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
		}
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
	}
	

	function CreatImage($img,$creatW,$creatH,$dstX,$dstY,$srcX,$srcY,$srcImgW,$srcImgH)
	{
		if(function_exists("imagecreatetruecolor"))
		{
			@$creatImg = ImageCreateTrueColor($creatW,$creatH);
			if($creatImg) 
				ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
			else
			{
				$creatImg=ImageCreate($creatW,$creatH);
			    ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
			}
		 }
		 else
		 {
			$creatImg=ImageCreate($creatW,$creatH);
			ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
		 }
		 return $creatImg;
	}
	
	//���ͼƬ��link---ֻ������������ļ���file--����Ϊ�ļ�
	function EchoImage($img,$to_File)
	{
		switch($this->echoType)
		{
			case "link":
				if(function_exists('imagejpeg')) return ImageJpeg($img);
				else return ImagePNG($img);
			    break;
			case "file":
				if(function_exists('imagejpeg')) return ImageJpeg($img,$to_File);
		        else return ImagePNG($img,$to_File);
				break;
		}
	}

}
?>