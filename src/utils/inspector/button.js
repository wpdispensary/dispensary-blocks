const { __ } = wp.i18n;
const { Fragment } = wp.element;
const {
	SelectControl,
    ToggleControl,
} = wp.components;
const {
	PanelColorSettings,
} = wp.editor;

export default function ButtonSettings( props ) {
    const {
        buttonBackgroundColor,
        onChangeButtonColor = () => {},
        buttonTextColor,
        onChangeButtonTextColor = () => {},
        buttonSize,
        onChangeButtonSize = () => {},
        buttonShape,
        onChangeButtonShape = () => {},
        buttonTarget,
        onChangeButtonTarget = () => {},
    } = props;

    // Button size values
    const buttonSizeOptions = [
        { value: 'wpd-button-size-small', label: __( 'Small', 'dispensary-blocks' ) },
        { value: 'wpd-button-size-medium', label: __( 'Medium', 'dispensary-blocks' ) },
        { value: 'wpd-button-size-large', label: __( 'Large', 'dispensary-blocks' ) },
        { value: 'wpd-button-size-extralarge', label: __( 'Extra Large', 'dispensary-blocks' ) },
    ];

    // Button shape
    const buttonShapeOptions = [
        { value: 'wpd-button-shape-square', label: __( 'Square', 'dispensary-blocks' ) },
        { value: 'wpd-button-shape-rounded', label: __( 'Rounded Square', 'dispensary-blocks' ) },
        { value: 'wpd-button-shape-circular', label: __( 'Circular', 'dispensary-blocks' ) },
    ];

    return (
        <Fragment>
            <ToggleControl
                label={ __( 'Open link in new window', 'dispensary-blocks' ) }
                checked={ buttonTarget }
                onChange={ onChangeButtonTarget }
            />

            <SelectControl
                selected={ buttonSize }
                label={ __( 'Button Size', 'dispensary-blocks' ) }
                value={ buttonSize }
                options={ buttonSizeOptions.map( ({ value, label }) => ( {
                    value: value,
                    label: label,
                } ) ) }
                onChange={ onChangeButtonSize }
            />

            <SelectControl
                label={ __( 'Button Shape', 'dispensary-blocks' ) }
                value={ buttonShape }
                options={ buttonShapeOptions.map( ({ value, label }) => ( {
                    value: value,
                    label: label,
                } ) ) }
                onChange={ onChangeButtonShape }
            />

            <PanelColorSettings
                title={ __( 'Button Color', 'dispensary-blocks' ) }
                initialOpen={ false }
                colorSettings={ [ {
                    value: buttonBackgroundColor,
                    onChange: onChangeButtonColor,
                    label: __( 'Button Color', 'dispensary-blocks' ),
                } ] }
            >
            </PanelColorSettings>

            <PanelColorSettings
                title={ __( 'Button Text Color', 'dispensary-blocks' ) }
                initialOpen={ false }
                colorSettings={ [ {
                    value: buttonTextColor,
                    onChange: onChangeButtonTextColor,
                    label: __( 'Button Text Color', 'dispensary-blocks' ),
                } ] }
            >
            </PanelColorSettings>
        </Fragment>
    );
}