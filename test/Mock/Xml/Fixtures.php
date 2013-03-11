<?php

/**
 * =============================================================================
 * @file        Mock/Xml/Fixtures.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Xml;

class Fixtures
{
    
    const FIXTURE1 = 
'<?xml version="1.0" encoding="UTF-8"?>
<test>
</test>';
    
    const FIXTURE2 = 
'<?xml version="1.0" encoding="UTF-8"?>
<test>some data</test>';
    
    const FIXTURE3 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests>
	<test>a</test>
	<test>b</test>
	<test>c</test>
</tests>';
    
    const FIXTURE4 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests>
	<a>123</a>
	<b>456</b>
	<c>789</c>
</tests>';
    
    const FIXTURE5 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests>
	<a>
		<number>1</number>
		<number>2</number>
		<number>3</number>
    </a>
	<b>
		<number>4</number>
		<number>5</number>
		<number>6</number>
    </b>
	<c>
		<number>7</number>
		<number>8</number>
		<number>9</number>
    </c>
</tests>';
    
    const FIXTURE6 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests>
	<a>
		<b>
			<c>666</c>
		</b>
	</a>
</tests>';
    
    const FIXTURE7 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests a="123" b="456" c="789">
	<test a="xyz" b="zyx" />
</tests>';
    
    const FIXTURE8 = 
'<?xml version="1.0" encoding="UTF-8"?>
<tests a="${x}" b="${y}">
	<test a="${a}" b="${b}" />
</tests>';
    
}
