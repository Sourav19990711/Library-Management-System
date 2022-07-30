<?php
/*
#
#
#############################################
#				----BeeHive----				#
#											#
#			Project Management System		#
#											#
#				Developed By 				#
#											#
#			  Goutam Chakraborty 			#
#					 &						#
#			Tirtharup Bhattacharyya			#
#											#
#############################################
#
#
*/
class xml_builder
{
	public function xml_builder()
	{
		//blank constructor
	}
	public function generate(array $data)
	{
		$xml = new SimpleXMLElement('<soap></soap>');
		$xml->addAttribute('xmlns', 'http://tempuri.org/');
		$xml_root = $xml->addChild('root');
		$this->buildContent($xml_root, $data);
		return $xml->asXML();
	}
	private function buildContent(SimpleXMLElement $object, array $data)
	{
		foreach ($data as $key => $value)
			{   
				if (is_array($value))
					{   
						$new_object = $object->addChild($key);
						$this->buildContent($new_object, $value);
					}   
				else
					{   
						$object->addChild($key, $value);
					}   
			}   
	}
	
}
