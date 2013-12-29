function OpenWindow(url, windowName, height, width, status, toolbar, Location, menubar, directories, resizable, scrollbars)
{
	url = typeof(url) != 'undefined' ? url : '';
	windowName = typeof(windowName) != 'undefined' ? windowName : '';
	windowFeatures = '';
	
	height = typeof(height) != 'undefined' ? (!isNaN(height) ? height : 400) : 400;
	width = typeof(width) != 'undefined' ? (!isNaN(width) ? width : 400) : 400;
	status = typeof(status) == 'undefined' ? 'no' : (status == true ? 'yes' : 'no');
	toolbar = typeof(toolbar) == 'undefined' ? 'no' : (toolbar == true ? 'yes' : 'no');
	Location = typeof(Location) == 'undefined' ? 'no' : (Location == true ? 'yes' : 'no');
	menubar = typeof(menubar) == 'undefined' ? 'no' : (menubar == true ? 'yes' : 'no');
	directories = typeof(directories) == 'undefined' ? 'no' : (directories == true ? 'yes' : 'no');
	resizable = typeof(resizable) == 'undefined' ? 'no' : (resizable == true ? 'yes' : 'no');
	scrollbars = typeof(scrollbars) == 'undefined' ? 'no' : (scrollbars == true ? 'yes' : 'no');
	
	windowFeatures += 'height=' + height; //Specifies the height of the window in pixels.
	windowFeatures += ',width=' + width; //Specifies the width of the window in pixels.
	windowFeatures += ',status=' + status; //The status bar at the bottom of the window. 
	windowFeatures += ',toolbar=' + toolbar; //The standard browser toolbar, with buttons such as Back and Forward.
	windowFeatures += ',location=' + Location; //The Location entry field where you enter the URL.
	windowFeatures += ',menubar=' + menubar; //The menu bar of the window
	windowFeatures += ',directories=' + directories; //The standard browser directory buttons, such as What's New and What's Cool
	windowFeatures += ',resizable=' + resizable; //Allow/Disallow the user to resize the window.
	windowFeatures += ',scrollbars=' + scrollbars; //Enable the scrollbars if the document is bigger than the window
	
	window . open(url, windowName, windowFeatures);
	//window . open('clientes/clientesGeralista.php', '11', 'width=410,height=400,scrolling=no,top=20');
}