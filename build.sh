clear

# Add-on name
echo "Enter Add-on name"
echo -e "\e[32mExample: Give Funds\e[0m"
read -p "" addon_name

while [ -z "$addon_name" ]
do
  	read -p "Enter Add-on name: " addon_name
done

# Add-on description
read -p "Add-on description: " addon_description

# TextDomain
echo "Enter add-on textdomain"
echo -e "\e[32mExample: give-funds\e[0m"
read -p "" addon_textdomain
while [ -z "$addon_textdomain" ] || [[ ! "$addon_textdomain" =~ ^give([a-z-])*$ ]]
do
	echo -e "\e[32mExample: give-funds\e[0m"
  	read -p "Enter valid add-on textdomain: " addon_textdomain
done

read -p "Build add-on? (y/n): " build_addon

if [ "$build_addon" != y ] ; then
	exit 1
fi

addon_constant=$( echo $( echo "$addon_name" | tr -s ' ' '_' ) | tr -cd "[:alnum:]_" )
addon_namespace=$( echo "$addon_name" | tr -cd "[:alnum:]" )

shopt -s globstar
files=(
	**/*.php
	"webpack.config.js"
	"wp-textdomain.js"
	"composer.json"
)

for file in "${files[@]}"
do
	# replace boilerplate namespace tag - convert to title case
	sed -i "s/GiveAddon/${addon_namespace[@]^}/" $file
	# replace add-on name tag - convert to title case
	sed -i "s/ADDON_NAME/${addon_name[@]^}/g" $file
	# replace add-on constant tag
	sed -i "s/ADDON_CONSTANT/${addon_constant^^}_ADDON/g" $file
	# replace add-on description tag
	sed -i "s/ADDON_DESCRIPTION/$addon_description/" $file
	# replace add-on textdomain tag
	sed -i "s/ADDON_TEXTDOMAIN/$addon_textdomain/g" $file
done

# delete this file
rm build.sh

clear

echo "Done!"
echo -e "\e[32mDon't forget to run composer install && npm install\e[0m"
echo -e "\e[32mHappy coding!\e[0m"
