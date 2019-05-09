# pixiExample

## Customize export
The example module can be used as a reference to extend the **TechDivision/Pixi** events.

## Dokumentation 
see [README.md](https://github.com/techdivision/pixiExample/tree/master/PixiApiCustomize) in PixiApiCustomize

### Install example
```
# Create local namespace in Magento
cd app/code

# clone pixiExample to your app/code folder with all Event example implementation
git clone https://github.com/techdivision/pixiExample.git

# Back to Magento root
cd ../..

# upgrade Magento, install the PixiApiCustomize
bin/magento setup:upgrade
bin/magento cache:flush
``` 
* Look how it works and create your own modul to override **Techdivision/Pixi** event
* Don't forget to remove the **pixiExample/PixiApiCustomize** if your own implementation works
